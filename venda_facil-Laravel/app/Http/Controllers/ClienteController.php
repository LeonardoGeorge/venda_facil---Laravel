<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('cliente', compact('clientes'));
    }

    public function create()
    {
        return view('cadastro-clientes');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'cpf' => 'required|string|max:14|unique:clientes',
            'endereco' => 'nullable|string|max:500', // Adicionei o endereço
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');
    }

    // Adicione estes métodos para edição
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('editar-cliente', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'cpf' => 'required|string|max:14|unique:clientes,cpf,' . $id,
            'endereco' => 'nullable|string|max:500',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function buscarPorNome($nome)
    {
        $cliente = Cliente::where('nome', 'ilike', "%{$nome}%")->first();

        if (!$cliente) {
            return response()->json(['erro' => 'Cliente não encontrado'], 404);
        }

        return response()->json($cliente);
    }
}