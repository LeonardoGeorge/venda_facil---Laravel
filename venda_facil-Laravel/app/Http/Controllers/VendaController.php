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
        try {
            $dados = $request->validate([
                'cliente_id' => 'nullable|integer',
                'cliente_nome' => 'required|string',
                'forma_pagamento' => 'required|string',
                'valor_total' => 'required|numeric',
                'produtos' => 'required|array'
            ]);

            // Registrar a venda no banco de dados
            $venda = new Venda();
            $venda->login = $dados['cliente_nome']; // Ou use cliente_id se disponível
            $venda->forma_pagamento = $dados['forma_pagamento'];
            $venda->valor_total = $dados['valor_total'];
            $venda->data_venda = now();
            $venda->save();

            // Registrar os produtos vendidos (se você tiver uma tabela para isso)
            foreach ($dados['produtos'] as $produto) {
                // Aqui você precisaria criar um modelo para os itens da venda
                // Exemplo: ItemVenda::create([...]);
            }

            return response()->json(['mensagem' => 'Venda registrada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['mensagem' => 'Erro ao registrar venda: ' . $e->getMessage()], 500);
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
