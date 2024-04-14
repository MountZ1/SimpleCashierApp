<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Http\Request;

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', function (Request $request) {
    return view('dashboard.index');
})->middleware('auth');

Route::resource('/dashboard/suppliers', SupplierController::class)->middleware('auth');
Route::resource('/dashboard/products', ProductController::class)->middleware('auth');
Route::get('/dashboard/products/{code}/take', [ProductController::class, 'take'])->middleware('auth');
Route::get('/dashboard/products/suggestion/{name}', [ProductController::class, 'nameSuggestion'])->middleware('auth');
Route::resource('/dashboard/orders', TransaksiController::class)->middleware('auth');
Route::get('/dashboard/orders/detail/{id}', [TransaksiController::class, 'show'])->middleware('auth');