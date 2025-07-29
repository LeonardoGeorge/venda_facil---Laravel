<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
