<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\FornecedorController;

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

// Rotas públicas
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    // Página inicial autenticada
    Route::get('/home', function () {
        return view('index');
    })->name('home');

    // Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ========== ROTAS DE VENDAS ==========
    Route::prefix('vendas')->group(function () {
        Route::get('/', [VendaController::class, 'index'])->name('vendas.index');
        Route::post('/registrar', [VendaController::class, 'registrarVenda'])->name('vendas.registrar');
        Route::post('/finalizar', [VendaController::class, 'finalizarVenda'])->name('vendas.finalizar');
        Route::post('/adicionar-produto-codigo', [VendaController::class, 'adicionarProdutoPorCodigoBarras'])->name('vendas.adicionar.codigo');

        // APIs para vendas
        Route::get('/buscar-produto/{id}', [VendaController::class, 'buscarProduto'])->name('vendas.buscar.produto');
        Route::get('/buscar-produto-codigo-barras/{codigoBarras}', [VendaController::class, 'buscarProdutoPorCodigoBarras'])->name('vendas.buscar.codigo');
        Route::get('/debug-codigos', [VendaController::class, 'debugCodigosBarras'])->name('vendas.debug.codigos');
    });

    // ========== ROTAS DE PRODUTOS ==========
    Route::prefix('produtos')->group(function () {
        Route::get('/', [ProdutoController::class, 'index'])->name('produtos.index');
        Route::get('/cadastro', [ProdutoController::class, 'create'])->name('produtos.create');
        Route::post('/cadastro', [ProdutoController::class, 'store'])->name('produtos.store');
        Route::get('/{id}/editar', [ProdutoController::class, 'edit'])->name('produtos.edit');
        Route::post('/{id}/editar', [ProdutoController::class, 'update'])->name('produtos.update');

        // APIs para produtos
        Route::get('/api/{id}', [ProdutoController::class, 'buscarProduto'])->name('produtos.api.buscar');
        Route::get('/api/codigo-barras/{codigoBarras}', [ProdutoController::class, 'buscarPorCodigoBarras'])->name('produtos.api.codigo');
    });

    // ========== ROTAS DE CLIENTES ==========
    Route::prefix('clientes')->group(function () {
        Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/cadastro', [ClienteController::class, 'create'])->name('clientes.create');
        Route::post('/cadastro', [ClienteController::class, 'store'])->name('clientes.store');
        Route::get('/{id}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
        Route::post('/{id}/editar', [ClienteController::class, 'update'])->name('clientes.update');
        Route::get('/buscar/{nome}', [ClienteController::class, 'buscarPorNome'])->name('clientes.buscar');
    });

    // ========== ROTAS FINANCEIRO ==========
    Route::prefix('financeiro')->group(function () {
        Route::get('/', [FinanceiroController::class, 'index'])->name('financeiro.index');
        Route::get('/filtrar', [FinanceiroController::class, 'filtrar'])->name('financeiro.filtrar');
    });

    // ========== ROTAS FORNECEDORES ==========
    Route::prefix('fornecedores')->group(function () {
        Route::get('/', [FornecedorController::class, 'index'])->name('fornecedores.index');
        Route::get('/cadastro', [FornecedorController::class, 'create'])->name('fornecedores.create');
        Route::post('/cadastro', [FornecedorController::class, 'store'])->name('fornecedores.store');
        Route::get('/{id}/editar', [FornecedorController::class, 'edit'])->name('fornecedores.edit');
        Route::put('/{id}', [FornecedorController::class, 'update'])->name('fornecedores.update');
        Route::delete('/{id}', [FornecedorController::class, 'destroy'])->name('fornecedores.destroy');
    });

    // Rotas de redirecionamento para compatibilidade
    Route::get('/venda', function () {
        return redirect()->route('vendas.index');
    })->name('venda');

    Route::get('/cadastro', function () {
        return redirect()->route('produtos.index');
    })->name('cadastro');

    Route::get('/cliente', function () {
        return redirect()->route('clientes.index');
    })->name('cliente');

    Route::get('/financeiro', function () {
        return redirect()->route('financeiro.index');
    })->name('financeiro');
});

require __DIR__ . '/auth.php';
