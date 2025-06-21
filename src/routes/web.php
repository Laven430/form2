<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');});
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::patch('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}/delete', [ProductController::class, 'destroy'])->name('products.destroy');