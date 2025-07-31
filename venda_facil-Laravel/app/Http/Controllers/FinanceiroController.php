<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceiroController extends Controller
{
    public function filtrar(Request $request)
    {
        $periodo = $request->query('periodo', 'diario');

        $query = DB::table('transacoes');

        if ($periodo === 'diario') {
            $query->whereDate('data_venda', now()->toDateString());
        } elseif ($periodo === 'semanal') {
            $query->whereBetween('data_venda', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]);
        } elseif ($periodo === 'mensal') {
            $query->whereMonth('data_venda', now()->month)
                ->whereYear('data_venda', now()->year);
        }

        $transacoes = $query->orderBy('data_venda', 'desc')->get();

        return response()->json($transacoes);
    }
}
