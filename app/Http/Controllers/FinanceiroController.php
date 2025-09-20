<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Venda; // ← Adicionar este use

class FinanceiroController extends Controller
{
    public function index()
    {
        $hoje = now()->toDateString();

        // Resumo diário - CORRIGIDO
        $totalDiario = DB::table('vendas')
            ->whereDate('created_at', $hoje) // ← data_venda → created_at
            ->sum('total'); // ← valor_total → total

        // Resumo semanal - CORRIGIDO
        $inicioSemana = now()->startOfWeek();
        $fimSemana = now()->endOfWeek();
        $totalSemanal = DB::table('vendas')
            ->whereBetween('created_at', [$inicioSemana, $fimSemana]) // ← data_venda → created_at
            ->sum('total'); // ← valor_total → total

        // Resumo mensal - CORRIGIDO
        $inicioMes = now()->startOfMonth();
        $fimMes = now()->endOfMonth();
        $totalMensal = DB::table('vendas')
            ->whereBetween('created_at', [$inicioMes, $fimMes]) // ← data_venda → created_at
            ->sum('total'); // ← valor_total → total

        // Lista de vendas (últimos 50 registros) - CORRIGIDO
        $vendas = DB::table('vendas')
            ->orderBy('created_at', 'desc') // ← data_venda → created_at
            ->limit(50)
            ->get();

        return view('financeiro', compact('totalDiario', 'totalSemanal', 'totalMensal', 'vendas'));
    }

    public function filtrar(Request $request)
    {
        $query = DB::table('vendas');

        // Filtro por data - CORRIGIDO
        if ($request->filled('inicio') && $request->filled('fim')) {
            $inicio = Carbon::parse($request->inicio)->startOfDay();
            $fim = Carbon::parse($request->fim)->endOfDay();
            $query->whereBetween('created_at', [$inicio, $fim]); // ← data_venda → created_at
        }

        // Filtro por cliente - CORRIGIDO (se você tiver tabela de clientes)
        if ($request->filled('cliente')) {
            // Se você tem relação com clientes, precisa fazer join
            $query->where('cliente_id', $request->cliente); // ← cliente → cliente_id
        }

        // Ordenação - CORRIGIDO
        $vendas = $query->orderBy('created_at', 'desc')->get(); // ← data_venda → created_at

        // Retorna JSON para AJAX
        return response()->json($vendas);
    }
}
