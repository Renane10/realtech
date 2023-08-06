<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TeamController;
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
Route::post('/addUsuario', [UserController::class, 'store'])->name('addUsuario')->middleware('auth');
Route::post('/editUsuario/{id}', [UserController::class, 'update'])->name('editUsuario')->middleware('auth');
Route::delete('/delUsuario/{id}', [UserController::class, 'deactivate'])->name('delUsuario')->middleware('auth');

// Rotas para o gerenciamento de equipes
Route::get('/equipes', [TeamController::class, 'index'])->name('equipes')->middleware('auth');
Route::post('/equipe', [TeamController::class, 'store'])->name('addEquipe')->middleware('auth');
Route::put('/equipe/{id}', [TeamController::class, 'update'])->name('editEquipe')->middleware('auth');
Route::delete('/delEquipe/{id}', [TeamController::class, 'destroy'])->name('delEquipe')->middleware('auth');

// Rotas para o gerenciamento de clientes
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes')->middleware('auth');
Route::post('/cliente', [ClienteController::class, 'store'])->name('addCliente')->middleware('auth');
Route::put('/cliente/{id}', [ClienteController::class, 'update'])->name('editCliente')->middleware('auth');
Route::delete('/cliente/{id}', [ClienteController::class, 'destroy'])->name('delCliente')->middleware('auth');