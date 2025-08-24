<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{
    public function index(){
        $produtos = Produto::all();
        return view('produtos', compact('produtos'));
    }

    public function create(){
        return view('cadastro-produtos');
    }

    public function store(Request $request){
        $produto = new Produto();
        $produto->nome_produto = $request->input('nome_produto');
        $produto->categoria = $request->input('categoria');
        $produto->preco_entrada = $request->input('preco_entrada');
        $produto->preco_saida = $request->input('preco_saida');
        $produto->quantidade = $request->input('quantidade');
        $produto->fornecedor = $request->input('fornecedor');
        $produto->save();

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function buscarProduto($id)
    {
        Log::info("=== BUSCANDO PRODUTO ID: $id ===");
        Log::info("ID recebido: " . $id);

        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['erro' => 'Produto não encontrado'], 404);
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
