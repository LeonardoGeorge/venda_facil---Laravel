<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceiroController extends Controller
{
    public function index() {
        //Resumo diario 
        $hoje = now()->toDateString();
        $totalDiario = DB::table('vendas')
        ->whereDate('data_venda', $hoje)
        ->sum('valor_total');

        // Resumo semanal
        $inicioSemana = now()->startOfWeek();
        $fimSemana = now()->endOfWeek();
        $totalSemanal = DB::table('vendas')
        ->whereBetween('data_venda', [$inicioSemana, $fimSemana])
        ->sum('valor_total');

        // REsumo mensal
        $inicioMes = now()->startOfMonth();
        $fimMes = now()->endOfMonth();
        $totalMensal = DB::table('vendas')
        ->whereBetween('data_venda', [$inicioMes, $fimMes])
        ->sum('valor_total');

        //Lista de vendas (últimos 50 registros)
        $vendas = DB::table('vendas')
        ->orderBy('data_venda', 'desc')
        ->limit(50)
        ->get();


        return view('financeiro', compact('totalDiario', 'totalSemanal', 'totalMensal', 'vendas'));
    }
}