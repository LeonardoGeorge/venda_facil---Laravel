<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    public function index()
    {
        return view('venda'); // Retorna a view 'venda.blade.php'
    }

    public function store(Request $request)
    {
        // Lógica para salvar dados (ex: formulário)
        return redirect()->route('venda.index');
    }
    public function registrarVenda(Request $request)
    {
        DB::table('transacoes')->insert([
            'cliente' => $request->input('cliente'),
            'forma_pagamento' => $request->input('forma_pagamento'),
            'valor_total' => $request->input('valor_total'),
            'data_venda' => now(), // ou $request->input('data_venda') se vier do frontend
        ]);

        return response()->json(['mensagem' => 'Venda registrada com sucesso!']);
    }
}
