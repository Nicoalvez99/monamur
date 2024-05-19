<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\RecordsController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\PremiumAccess;
use App\Http\Middleware\AdminAccess;
use Illuminate\Support\Facades\Mail;
use App\Mail\MonamurMailer;
use App\Models\Productos;
use Illuminate\Support\Facades\Auth;

//Rutas web
Route::get('/', [ProductosController::class, 'indexSimple']);


//Rutas normales de usuario registrado y simple
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/mis-productos', [ProductosController::class, 'index'])->middleware(['auth', 'verified'])->name('mis.productos'); // Panel de productos
Route::get('/editar-producto/{producto}', [ProductosController::class, 'edit'])->middleware(['auth', 'verified'])->name('editar.producto'); //Página para editar producto
Route::get('/mi-stock', [RecordsController::class, 'indexStock'])->middleware(['auth', 'verified'])->name('historial');
Route::get('/mensajes', function(){
    return view('mensajes');
})->name('mensajes');
Route::post('/productos', [ProductosController::class, 'store'])->middleware(['auth', 'verified'])->name('productos.create'); // post de agregar producto
Route::patch('/editar-producto/{producto}', [ProductosController::class, 'update'])->middleware(['auth', 'verified'])->name('update.producto');
Route::delete('/editar-producto/{producto}', [ProductosController::class, 'destroy'])->middleware(['auth', 'verified'])->name('delete.producto');

//Usuarios premium
Route::middleware([PremiumAccess::class, AdminAccess::class])->group(function(){
    Route::get('/gestion-ventas', [ComprasController::class, 'index'])->middleware(['auth', 'verified'])->name('ventas');
    Route::get('/charts', [RecordsController::class, 'indexCharts'])->middleware(['auth', 'verified'])->name('charts');
    Route::post('/gestion-ventas', [ComprasController::class, 'store'])->middleware(['auth', 'verified'])->name('ventas.store');
    Route::delete('/gestion-ventas', [ComprasController::class, 'destroy'])->middleware(['auth', 'verified'])->name('compra.delete');
});
//Rutas Admin user
Route::middleware([AdminAccess::class])->group(function () {
    Route::get('/administrador', [AdminController::class, 'index'])->name('admin');
});
//Auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
