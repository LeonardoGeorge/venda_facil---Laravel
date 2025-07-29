<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function create()
    {
        return view('cadastro-fornecedores');
    }

    public function store(request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18|unique:fornecedores,cnpj',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'required|string|size:2'
        ]);
        Fornecedor::create($request->only([
            'nome',
            'cnpj',
            'telefone',
            'email',
            'endereco',
            'cidade',
            'estado'
        ]));

        return redirect()->route('fornecedores.create')->with('success', 'Fornecedor cadastrado com sucesso!');
    }
}
