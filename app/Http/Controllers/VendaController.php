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

            // No VendaController::finalizarVenda()
            $venda = Venda::create([
                'cliente' => $request->cliente, // Usar o nome do cliente
                'forma_pagamento' => $request->forma_pagamento,
                'valor_total' => $request->total,
                'data_venda' => now(),

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
        // Validação dos dados - permitir quantidades decimais
        $validated = $request->validate([
            'cliente_id' => 'nullable|integer|exists:clientes,id',
            'forma_pagamento' => 'required|string|max:50',
            'total' => 'required|numeric|min:0',
            'itens' => 'required|array|min:1',
            'itens.*.produto_id' => 'required|integer|exists:produtos,id',
            'itens.*.quantidade' => 'required|numeric|min:0.01', // Alterado para numeric e mínimo 0.01
            'itens.*.preco' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Criar a venda
            $venda = Venda::create([
                'cliente_id' => $validated['cliente_id'],
                'forma_pagamento' => $validated['forma_pagamento'],
                'total' => $validated['total'],
                'finalizada' => true,
                'data_venda' => now(),
            ]);

            // Processar itens da venda
            foreach ($validated['itens'] as $item) {
                $produto = Produto::findOrFail($item['produto_id']);

                // Verificar estoque - considerar quantidades decimais
                if ($produto->quantidade < $item['quantidade']) {
                    throw new \Exception("Estoque insuficiente para o produto: {$produto->nome}. Disponível: {$produto->quantidade}, Solicitado: {$item['quantidade']}");
                }

                // Atualizar estoque - usar decrement com valor decimal
                $produto->quantidade = $produto->quantidade - $item['quantidade'];
                $produto->save();

                // Criar item da venda
                VendaItem::create([
                    'venda_id' => $venda->id,
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'preco' => $item['preco'],
                    'subtotal' => $item['quantidade'] * $item['preco'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Venda registrada com sucesso!',
                'venda_id' => $venda->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar venda: ' . $e->getMessage()
            ], 500);
        }
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!$request->ajax() && !$request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Apenas requisições JSON são permitidas'
                ], 400);
            }
            return $next($request);
        })->only(['finalizarVenda']);
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