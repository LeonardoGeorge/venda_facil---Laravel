<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\FinanceiroController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('index');
});

Route::get('/api/produtos/{codigo}', [ProdutoController::class, 'buscarPorCodigo']);
Route::get('/api/clientes/{nome}', [ClienteController::class, 'buscarPorNome']);

Route::get('/api/produtos/{codigo}', [ProdutoController::class, 'buscarPorCodigo']);
Route::get('/api/clientes/{nome}', [ClienteController::class, 'buscarPorNome']);

// CADASTROS SIMPLES (sem controller por enquanto)
Route::view('/cadastro', 'cadastro');
Route::view('/venda', 'venda');
Route::view('/financeiro', 'financeiro');
Route::view('/estoque', 'estoque');

// CLIENTES
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('/clientes/cadastrar', [ClienteController::class, 'create'])->name('clientes.create');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

// FORNECEDORES
Route::get('/fornecedores', [FornecedorController::class, 'index'])->name('fornecedores.index');
Route::get('/fornecedores/cadastrar', [FornecedorController::class, 'create'])->name('fornecedores.create');
Route::post('/fornecedores', [FornecedorController::class, 'store'])->name('fornecedores.store');

Route::get('/cliente', function () {
    return view('cliente');
});
Route::get('/financeiro', function () {
    return view('financeiro');
});
Route::get('/estoque', function () {
    return view('estoque');
});
Route::get('/cadastro-clientes', function () {
    return view('cadastro-clientes');
});
Route::get('/cadastro-fornecedor', function () {
    return view('cadastro-fornecedor');
});
Route::get('/cadastro-produtos', function () {
    return view('cadastro-produtos');
});


// PRODUTOS
Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
Route::get('/produtos/cadastrar', [ProdutoController::class, 'create'])->name('produtos.create');
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');