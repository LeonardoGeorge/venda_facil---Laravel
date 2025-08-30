<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedor::all();
        return view('fornecedores', compact('fornecedores'));
    }

    public function create()
    {
        return view('cadastro-fornecedores');
    }

    public function store(Request $request)
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

    // Métodos adicionais para completar o CRUD
    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        return view('editar-fornecedor', compact('fornecedor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18|unique:fornecedores,cnpj,' . $id,
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'required|string|size:2'
        ]);

        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->update($request->all());

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->delete();

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor excluído com sucesso!');
    }
}
