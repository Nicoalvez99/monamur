<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\RecordsController;
use Illuminate\Support\Facades\Mail;
use App\Mail\MonamurMailer;

//Rutas web
Route::get('/', function () {
    return view('welcome');
});

Route::get('/mail-send', function() {
   Mail::to('nicoalvez99@gmail.com')->send(new MonamurMailer()); 
});

//Rutas normales de usuario registrado
Route::get('/dashboard', function () {  //Dashboard
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/mis-productos', [ProductosController::class, 'index'])->name('mis.productos'); // Panel de productos
Route::get('/editar-producto/{producto}', [ProductosController::class, 'edit'])->name('editar.producto'); //Página para editar producto
Route::get('/gestion-ventas', [ComprasController::class, 'index'])->name('ventas');
Route::get('/mi-stock', [RecordsController::class, 'indexStock'])->name('historial');
Route::post('/productos', [ProductosController::class, 'store'])->name('productos.create'); // post de agregar producto
Route::post('/gestion-ventas', [ComprasController::class, 'store'])->name('ventas.store');
Route::patch('/editar-producto/{producto}', [ProductosController::class, 'update'])->name('update.producto');
Route::delete('/gestion-ventas', [ComprasController::class, 'destroy'])->name('compra.delete');
Route::delete('/editar-producto/{producto}', [ProductosController::class, 'destroy'])->name('delete.producto');
//Auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
