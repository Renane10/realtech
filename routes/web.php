<?php
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/users', [UserController::class, 'usuarios']);
Route::get('/users', [UserController::class, 'index'])->name('users.index');
