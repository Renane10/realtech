<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Lógica de autenticação
        $credentials = $request->only('login', 'password');

        if (auth()->attempt($credentials)) {
            // Autenticação bem-sucedida
            return response()->json(['message' => 'Logado com sucesso!']);
        } else {
            // Autenticação falhou
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('welcome');
    }
}