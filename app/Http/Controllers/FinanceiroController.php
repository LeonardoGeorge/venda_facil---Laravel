<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinanceiroController extends Controller
{
    public function index()
    {
        $hoje = now()->toDateString();

        // Resumo diário
        $totalDiario = DB::table('vendas')
            ->whereDate('data_venda', $hoje)
            ->sum('valor_total');

        // Resumo semanal
        $inicioSemana = now()->startOfWeek();
        $fimSemana = now()->endOfWeek();
        $totalSemanal = DB::table('vendas')
            ->whereBetween('data_venda', [$inicioSemana, $fimSemana])
            ->sum('valor_total');

        // Resumo mensal
        $inicioMes = now()->startOfMonth();
        $fimMes = now()->endOfMonth();
        $totalMensal = DB::table('vendas')
            ->whereBetween('data_venda', [$inicioMes, $fimMes])
            ->sum('valor_total');

        // Lista de vendas (últimos 50 registros)
        $vendas = DB::table('vendas')
            ->orderBy('data_venda', 'desc')
            ->limit(50)
            ->get();

        return view('financeiro', compact('totalDiario', 'totalSemanal', 'totalMensal', 'vendas'));
    }

    public function filtrar(Request $request)
    {
        $query = DB::table('vendas');

        // Filtro por data
        if ($request->filled('inicio') && $request->filled('fim')) {
            $inicio = Carbon::parse($request->inicio)->startOfDay();
            $fim = Carbon::parse($request->fim)->endOfDay();
            $query->whereBetween('data_venda', [$inicio, $fim]);
        }

        // Filtro por cliente
        if ($request->filled('cliente')) {
            $query->where('cliente', 'LIKE', '%' . $request->cliente . '%');
        }

        // Ordenação
        $vendas = $query->orderBy('data_venda', 'desc')->get();

        // Retorna JSON para AJAX
        return response()->json($vendas);
    }
}
