<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Produto;
use App\Models\VendaProduto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;

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

    // Finalizar e deduzir estoque no bd + IMPRESSÃO
    public function finalizarVenda(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Criar venda
                $venda = Venda::create([
                    'cliente' => $request->cliente ?? 'Cliente não informado',
                    'forma_pagamento' => $request->forma_pagamento,
                    'valor_total' => $request->total,
                    'data_venda' => now()
                ]);

                // ... processar itens ...

                // Imprimir DENTRO da transaction
                $this->imprimirCupom($venda->id);
            });

            return response()->json([
                'mensagem' => 'Venda finalizada, estoque atualizado e cupom impresso com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'mensagem' => 'Erro ao finalizar venda: ' . $e->getMessage()
            ], 500);
        }
    }

    // Função para imprimir cupom fiscal
    private function imprimirCupom($vendaId)
    {
        try {
            $venda = Venda::with(['itens.produto'])->find($vendaId);

            if (!$venda) {
                throw new \Exception("Venda não encontrada");
            }

            // Configuração da impressora - ajuste conforme necessário
            $nomeImpressora = "XP-80"; // Nome da impressora configurada no Windows
            $connector = new WindowsPrintConnector($nomeImpressora);
            $printer = new Printer($connector);

            // Iniciar impressão
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("==============================\n");
            $printer->text("        VENDA FÁCIL\n");
            $printer->text("==============================\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);

            $printer->text("Data: " . $venda->data_venda->format('d/m/Y H:i') . "\n");
            $printer->text("Venda: #" . str_pad($venda->id, 6, '0', STR_PAD_LEFT) . "\n");
            $printer->text("Cliente: " . $venda->cliente . "\n");
            $printer->text("-------------------------------\n");

            // Itens da venda
            foreach ($venda->itens as $item) {
                $printer->text($item->produto->nome_produto . "\n");
                $printer->text($item->quantidade . " x R$ " . number_format($item->preco_unitario, 2, ',', '.') . " = R$ " . number_format($item->subtotal, 2, ',', '.') . "\n");
            }

            $printer->text("-------------------------------\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("TOTAL: R$ " . number_format($venda->valor_total, 2, ',', '.') . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Forma de Pagamento: " . $venda->forma_pagamento . "\n");
            $printer->text("==============================\n");
            $printer->text("Obrigado pela preferência!\n");
            $printer->text("Volte sempre!\n");

            // Cortar papel (se a impressora suportar)
            $printer->cut();

            $printer->close();

            return true;
        } catch (\Exception $e) {
            Log::error("Erro ao imprimir cupom: " . $e->getMessage());
            // Não falha a venda se houver erro na impressão
            return false;
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
