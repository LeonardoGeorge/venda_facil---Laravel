<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Produto;
use App\Models\VendaProduto; // Importar o novo model
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    public function index()
    {
        $produtos = Produto::where('ativo', true)->get();
        return view('venda', compact('produtos'));
    }

    public function registrarVenda(Request $request)
    {
        $request->validate([
            'cliente' => 'required|string|max:255',
            'forma_pagamento' => 'required|string|in:dinheiro,cartao,pix,transferencia',
            'valor_total' => 'required|numeric|min:0',
            'produtos' => 'required|array|min:1',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            // Criar a venda
            $venda = Venda::create([
                'cliente' => $request->cliente,
                'forma_pagamento' => $request->forma_pagamento,
                'valor_total' => $request->valor_total,
                'data_venda' => now()
            ]);

            // Adicionar produtos à venda
            foreach ($request->produtos as $produtoData) {
                $produto = Produto::find($produtoData['id']);
                $subtotal = $produtoData['quantidade'] * $produto->preco;

                VendaProduto::create([
                    'venda_id' => $venda->id,
                    'produto_id' => $produto->id,
                    'quantidade' => $produtoData['quantidade'],
                    'preco_unitario' => $produto->preco,
                    'subtotal' => $subtotal
                ]);

                // Atualizar estoque
                $produto->decrement('estoque', $produtoData['quantidade']);
            }

            DB::commit();

            return response()->json([
                'mensagem' => 'Venda registrada com sucesso!',
                'venda_id' => $venda->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'mensagem' => 'Erro ao registrar venda: ' . $e->getMessage()
            ], 500);
        }
    }

    public function buscarProduto($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        return response()->json([
            'id' => $produto->id,
            'nome_produto' => $produto->nome_produto,
            'preco_saida' => $produto->preco_saida,
            'quantidade' => $produto->quantidade,
            'categoria' => $produto->categoria,
            'fornecedor' => $produto->fornecedor
        ]);
    }
}
