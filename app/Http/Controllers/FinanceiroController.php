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

        // Use o mesmo campo em todos os lugares - escolha entre created_at ou data_venda
        $vendas = DB::table('vendas')
            ->leftJoin('clientes', 'vendas.cliente_id', '=', 'clientes.id')
            ->select(
                'vendas.*',
                'clientes.nome as name_cliente',
                'vendas.total as valor_total' // ← ALIAS para compatibilidade
            )
            ->orderBy('vendas.created_at', 'desc')
            ->limit(50)
            ->get();

        return view('financeiro', compact('vendas'));
    }

    public function filtrar(Request $request)
    {
        $query = DB::table('vendas')
            ->leftJoin('clientes', 'vendas.cliente_id', '=', 'clientes.id')
            ->select(
                'vendas.*',
                'clientes.nome as name_cliente', 
                 'vendas.total as valor_total'
            );

        // Filtro por data
        if ($request->filled('inicio') && $request->filled('fim')) {
            $inicio = Carbon::parse($request->inicio)->startOfDay();
            $fim = Carbon::parse($request->fim)->endOfDay();
            $query->whereBetween('vendas.created_at', [$inicio, $fim]);
        }

        // Filtro por cliente
        if ($request->filled('cliente')) {
            $query->where('clientes.nome', 'like', '%' . $request->cliente . '%');
        }

        $vendas = $query->orderBy('vendas.created_at', 'desc')->get();

        return response()->json($vendas);
    }
}
