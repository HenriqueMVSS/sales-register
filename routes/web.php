<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Rotas de Vendas
    Route::resource('sales', SaleController::class);
    Route::get('sales/{sale}/pdf', [SaleController::class, 'generatePDF'])->name('sales.pdf');

    // Rotas de Clientes
    Route::resource('customers', CustomerController::class);

    // Rotas de Produtos
    Route::resource('products', ProductController::class);
});
