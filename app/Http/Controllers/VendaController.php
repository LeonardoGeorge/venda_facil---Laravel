<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Venda;
use App\Models\VendaItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VendaController extends Controller
{
    /**
     * Tela inicial de vendas
     */
    public function index()
    {
        return view('venda');
    }

    /**
     * Registrar uma venda (sem finalizar estoque ainda)
     */
    public function registrarVenda(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|integer',
            'itens' => 'required|array',
            'itens.*.produto_id' => 'required|integer',
            'itens.*.quantidade' => 'required|integer|min:1',
            'itens.*.preco' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $venda = Venda::create([
                'cliente_id' => $request->cliente_id,
                'total' => collect($request->itens)->sum(fn($i) => $i['quantidade'] * $i['preco']),
            ]);

            foreach ($request->itens as $item) {
                VendaItem::create([
                    'venda_id' => $venda->id,
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'preco' => $item['preco'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Venda registrada com sucesso!',
                'venda_id' => $venda->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erro ao registrar venda: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao registrar venda',
            ], 500);
        }
    }

    /**
     * Finalizar a venda: deduz estoque e confirma
     */
    public function finalizarVenda(Request $request)
{
    $request->validate([
        'cliente_id' => 'nullable|integer',
        'forma_pagamento' => 'required|string',
        'total' => 'required|numeric|min:0',
        'itens' => 'required|array',
        'itens.*.produto_id' => 'required|integer',
        'itens.*.quantidade' => 'required|integer|min:1',
        'itens.*.preco' => 'required|numeric|min:0',
    ]);

    try {
        DB::beginTransaction();

        // Criar a venda
        $venda = Venda::create([
            'cliente_id' => $request->cliente_id,
            'forma_pagamento' => $request->forma_pagamento,
            'total' => $request->total,
            'finalizada' => true,
        ]);

        foreach ($request->itens as $item) {
            $produto = Produto::findOrFail($item['produto_id']);

            if ($produto->quantidade < $item['quantidade']) {
                throw new \Exception("Estoque insuficiente para o produto {$produto->nome}");
            }

            // Deduzir estoque
            $produto->quantidade -= $item['quantidade'];
            $produto->save();

            // Criar item da venda
            VendaItem::create([
                'venda_id' => $venda->id,
                'produto_id' => $item['produto_id'],
                'quantidade' => $item['quantidade'],
                'preco' => $item['preco'],
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Venda registrada e finalizada com sucesso!',
            'venda_id' => $venda->id,
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Erro ao finalizar venda: " . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Erro ao finalizar venda: ' . $e->getMessage(),
        ], 500);
    }
}

    /**
     * Imprimir nota fiscal (simples)
     */
    public function imprimirNotaFiscal($id)
    {
        $venda = Venda::with('itens.produto')->findOrFail($id);
        return view('nota-fiscal', compact('venda'));
    }
}
