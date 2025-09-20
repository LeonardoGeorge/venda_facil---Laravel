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

    // Adicionar produto via código de barras (nova função)
    public function adicionarProdutoPorCodigoBarras(Request $request)
    {
        try {
            $codigoBarras = $request->codigo_barras;
            $produto = Produto::where('codigo_barras', $codigoBarras)->first();

            if (!$produto) {
                return response()->json(['erro' => 'Produto não encontrado'], 404);
            }

            return response()->json([
                'success' => true,
                'produto' => [
                    'id' => $produto->id,
                    'nome_produto' => $produto->nome_produto,
                    'preco_saida' => $produto->preco_saida,
                    'quantidade' => $produto->quantidade,
                    'codigo_barras' => $produto->codigo_barras
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['erro' => 'Erro ao buscar produto: ' . $e->getMessage()], 500);
        }
    }

    public function finalizarVenda(Request $request)
{
        try {
            $vendaData = null; // Inicializa a variável

            DB::transaction(function () use ($request, &$vendaData) { // Note o & antes de $vendaData
                // Criar venda (usando a estrutura da sua tabela vendas)
                $venda = Venda::create([
                    'cliente' => $request->cliente ?? 'Cliente não informado',
                    'forma_pagamento' => $request->forma_pagamento,
                    'valor_total' => $request->total,
                    'data_venda' => now()
                ]);

                $vendaData = $venda; // Atribui o valor à variável por referência

                foreach ($request->itens as $item) {
                // Converta para float
                $quantidade = (float) $item['quantidade'];
                $preco = (float) $item['preco'];
                
                $subtotal = $quantidade * $preco;

                VendaProduto::create([
                    'venda_id' => $venda->id,
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $quantidade, // Use a variável convertida
                    'preco_unitario' => $preco,  // Use a variável convertida
                    'subtotal' => $subtotal
                ]);

                $produto = Produto::find($item['produto_id']);

                if (!$produto) {
                    throw new \Exception("Produto ID {$item['produto_id']} não encontrado");
                }

                // Use a variável convertida
                if ($produto->quantidade < $quantidade) {
                    throw new \Exception("Estoque insuficiente para: {$produto->nome_produto}");
                }

                $produto->quantidade -= $quantidade;
                $produto->save();
            }
        });

        // ... resto do código ...
    } catch (\Exception $e) {
        Log::error("Erro ao finalizar venda: " . $e->getMessage());
        return response()->json([
            'mensagem' => 'Erro ao finalizar venda: ' . $e->getMessage(),
            'success' => false
        ], 500);
    }
}

    // Adicione este novo método para impressão
    public function imprimirNotaFiscal($id)
    {
        try {
            $venda = Venda::with(['itens.produto'])->find($id);

            if (!$venda) {
                return response()->json(['erro' => 'Venda não encontrada'], 404);
            }

            return response()->json([
                'venda' => $venda,
                'itens' => $venda->itens->map(function ($item) {
                    return [
                        'nome' => $item->produto->nome_produto,
                        'quantidade' => $item->quantidade,
                        'preco_unitario' => $item->preco_unitario,
                        'subtotal' => $item->subtotal
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json(['erro' => 'Erro ao buscar dados da venda: ' . $e->getMessage()], 500);
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

    // Novo método para obter dados da venda para impressão (opcional)
    public function obterDadosVenda($id)
    {
        try {
            $venda = Venda::with(['itens.produto'])->find($id);

            if (!$venda) {
                return response()->json(['erro' => 'Venda não encontrada'], 404);
            }

            return response()->json([
                'venda' => $venda,
                'itens' => $venda->itens->map(function ($item) {
                    return [
                        'nome' => $item->produto->nome_produto,
                        'quantidade' => $item->quantidade,
                        'preco_unitario' => $item->preco_unitario,
                        'subtotal' => $item->subtotal
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json(['erro' => 'Erro ao buscar dados da venda: ' . $e->getMessage()], 500);
        }
    }
}
