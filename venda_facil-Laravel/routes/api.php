<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/financeiro', [App\Http\Controllers\FinanceiroController::class, 'filtrar']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// API para buscar produto
Route::get('/produtos/{id}', [ProdutoController::class, 'buscarProduto']);

// Rota para registrar venda
Route::post('/venda/registrar', [VendaController::class, 'registrarVenda']);