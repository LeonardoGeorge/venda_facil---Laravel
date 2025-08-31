<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Produto;
use App\Models\VendaProduto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VendaController extends Controller
{
    public function index()
    {
        $produtos = Produto::where('ativo', true)->get();
        return view('venda', compact('produtos'));
    }

    public function registrarVenda(Request $request)
    {
        try {
            // REMOVA A VALIDAÇÃO OBRIGATÓRIA DO cliente_nome
            $dados = $request->validate([
                'cliente_id' => 'nullable|integer',
                'cliente' => 'nullable|string',  // MUDEI PARA cliente E TORNEI OPCIONAL
                'forma_pagamento' => 'required|string',
                'valor_total' => 'required|numeric',
                'produtos' => 'required|array'
            ]);

            // Registrar a venda no banco de dados
            $venda = new Venda();
            $venda->cliente = $dados['cliente'] ?? 'Cliente não informado'; // USA cliente E DEFINE VALOR PADRÃO
            $venda->forma_pagamento = $dados['forma_pagamento'];
            $venda->valor_total = $dados['valor_total'];
            $venda->data_venda = now();
            $venda->save();

            return response()->json(['mensagem' => 'Venda registrada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao registrar venda: ' . $e->getMessage(),
                'erro' => $e->getMessage()
            ], 500);
        }
    }

    // Buscar produto por ID
    public function buscarProduto($id)
    {
        Log::info("=== BUSCANDO PRODUTO POR ID: $id ===");

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
            'fornecedor' => $produto->fornecedor,
            'codigo_barras' => $produto->codigo_barras // Adicionado para compatibilidade
        ]);
    }

    // Buscar produto por código de barras
    public function buscarProdutoPorCodigoBarras($codigoBarras)
    {
        Log::info("=== BUSCANDO PRODUTO POR CÓDIGO DE BARRAS: $codigoBarras ===");

        // Busca pelo código de barras
        $produto = Produto::where('codigo_barras', $codigoBarras)->first();

        if (!$produto) {
            Log::error("Produto não encontrado para código de barras: $codigoBarras");

            // Tentativa alternativa: verificar se há espaços ou caracteres especiais
            $codigoLimpo = preg_replace('/[^0-9]/', '', $codigoBarras);
            if ($codigoLimpo !== $codigoBarras) {
                Log::info("Tentando busca com código limpo: $codigoLimpo");
                $produto = Produto::where('codigo_barras', $codigoLimpo)->first();
            }

            if (!$produto) {
                return response()->json(['erro' => 'Produto não encontrado'], 404);
            }
        }

        Log::info("Produto encontrado: " . $produto->nome_produto);

        return response()->json([
            'id' => $produto->id,
            'nome_produto' => $produto->nome_produto,
            'preco_saida' => $produto->preco_saida,
            'quantidade' => $produto->quantidade,
            'categoria' => $produto->categoria,
            'fornecedor' => $produto->fornecedor,
            'codigo' => $produto->id,
            'codigo_barras' => $produto->codigo_barras
        ]);
    }

    //  Finalizar e deduzir estoque no bd
    public function finalizarVenda(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Criar venda (usando a estrutura da sua tabela vendas)
                $venda = Venda::create([
                    'cliente' => $request->cliente ?? 'Cliente não informado',
                    'forma_pagamento' => $request->forma_pagamento,
                    'valor_total' => $request->total,
                    'data_venda' => now()
                ]);

                // Percorre cada item da venda
                foreach ($request->itens as $item) {
                    // Calcular subtotal
                    $subtotal = $item['quantidade'] * $item['preco'];

                    // Registrar na tabela venda_produtos
                    VendaProduto::create([
                        'venda_id' => $venda->id,
                        'produto_id' => $item['produto_id'],
                        'quantidade' => $item['quantidade'],
                        'preco_unitario' => $item['preco'],
                        'subtotal' => $subtotal
                    ]);

                    // Atualiza estoque na tabela produtos
                    $produto = Produto::find($item['produto_id']);

                    if (!$produto) {
                        throw new \Exception("Produto ID {$item['produto_id']} não encontrado");
                    }

                    if ($produto->quantidade < $item['quantidade']) {
                        throw new \Exception("Estoque insuficiente para o produto {$produto->nome_produto}");
                    }

                    // 🔥 DEDUZINDO O ESTOQUE - campo 'quantidade' na tabela produtos
                    $produto->quantidade -= $item['quantidade'];
                    $produto->save();
                }
            });

            return response()->json(['mensagem' => 'Venda finalizada e estoque atualizado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao finalizar venda: ' . $e->getMessage()
            ], 500);
        }
    }

    // Método adicional para debug - listar todos os produtos com código de barras
    public function debugCodigosBarras()
    {
        $produtosComCodigo = Produto::whereNotNull('codigo_barras')
            ->where('codigo_barras', '!=', '')
            ->get(['id', 'nome_produto', 'codigo_barras']);

        return response()->json($produtosComCodigo);
    }
}
