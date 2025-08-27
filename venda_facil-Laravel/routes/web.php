<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FinanceiroController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('home');

// Rotas de autenticação (públicas)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Dashboard (se ainda quiser mantê-la)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas protegidas
Route::middleware('auth')->group(
    function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Adicione outras rotas protegidas aqui
        Route::get('/venda', function () {
            return view('venda');
        })->name('venda');

        // Rotas para vendas
        Route::get('/venda', [VendaController::class, 'index'])->name('venda.index');
        Route::post('/venda/registrar', [VendaController::class, 'registrarVenda'])->name('venda.registrar');
        Route::get('/api/produtos/{id}', [ProdutoController::class, 'buscarProduto']);

        Route::get('/cadastro', function () {
            return view('cadastro');
        })->name('cadastro');

        Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
        Route::get('/produtos/{id}/editar', [ProdutoController::class, 'edit'])->name('produtos.edit');
        Route::post('/produtos/{id}/editar', [ProdutoController::class, 'update'])->name('produtos.update');

        // Rota para MOSTRAR o formulário (GET)
        Route::get('/cadastro-produtos', [ProdutoController::class, 'create'])
        ->name('cadastro.produtos.form');

        // Rota para PROCESSAR o formulário (POST)  
        Route::post('/cadastro-produtos', [ProdutoController::class, 'store'])
        ->name('cadastro.produtos.store');

        // Ou use resource (recomendado)
        Route::resource('produtos', ProdutoController::class);

        Route::get('/clientes', [ClienteController::class, 'index'])
            ->name('clientes.index');

        Route::get('/cadastro-clientes', [ClienteController::class, 'create'])
            ->name('cadastro.clientes.form');

        Route::post('/cadastro-clientes', [ClienteController::class, 'store'])
            ->name('cadastro.clientes.store');

        Route::get('/buscar-cliente/{nome}', [ClienteController::class, 'buscarPorNome']);


        // Financeiro 
        Route::get('/financeiro', [FinanceiroController::class, 'index'])->name('financeiro');

        // Financeiro Filtrar
        Route::get('/financeiro/filtrar', [FinanceiroController::class, 'filtrar'])->name('financeiro.filtrar');
    }

);

require __DIR__.'/auth.php';
