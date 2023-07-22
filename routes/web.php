<?php
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/inicio', function () {
    return view('inicio');
})->name('inicio')->middleware('auth');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios')->middleware('auth');
Route::get('/attUsuario', [UserController::class, 'update'])->name('attUsuario')->middleware('auth');
Route::post('/addUsuario', [UserController::class, 'store'])->name('addUsuario')->middleware('auth');
Route::post('/editUsuario', [UserController::class, 'update'])->name('editUsuario')->middleware('auth');
Route::post('/delUsuario', [UserController::class, 'deactivate'])->name('delUsuario')->middleware('auth');
