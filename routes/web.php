<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\OrderFoodController;

Route::get('/', function () {
    return redirect()->route('user.ordermenu');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/admin/kategori', \App\Http\Controllers\Admin\KategoriController::class);
    Route::resource('/admin/menu', \App\Http\Controllers\Admin\MenuController::class);

    Route::get('admin/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::put('admin/pesanan/update-status/{id}', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

});

Route::get('/order', [OrderFoodController::class, 'index'])->name('user.ordermenu');
Route::post('/checkout', [OrderFoodController::class, 'storePesanan'])->name('user.checkout');
