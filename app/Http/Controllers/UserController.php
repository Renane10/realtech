<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $linhas = User::all();
        $titulo = 'Gerenciamento de Usuários';
        $descricao = 'Aqui você pode cadastrar, editar e inativar os usuários do sistema';
        // Configuração das colunas da tabela
        $colunas = [
            'name' => 'Nome',
            'login' => 'Login',
            'email' => 'E-mail',
            'team' => 'Equipe',
        ];
        return view('lista', compact('linhas', 'colunas','titulo', 'descricao'));
    }
    public function store(Request $request)
    {
        // Validação dos dados de entrada
        $validatedData = $request->validate([
            'name' => 'required|string',
            'login' => 'required|unique:users',
            'password' => 'required',
            'email' => 'required|email|unique:users',
            'team_id' => 'required|exists:teams,id',
        ]);

        // Criação do usuário
        $user = User::create($validatedData);

        return response()->json(['message' => 'Usuario criado', 'user' => $user]);
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados de entrada
        $validatedData = $request->validate([
            'name' => 'required|string',
            'login' => 'required|unique:users,login,' . $id,
            'password' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'team_id' => 'required|exists:teams,id',
        ]);

        // Atualização do usuário
        $user = User::findOrFail($id);
        $user->update($validatedData);

        return response()->json(['message' => 'Usuario atualizado', 'user' => $user]);
    }

    public function deactivate($id)
    {
        // Inativação do usuário
        $user = User::findOrFail($id);
        $user->active = false;
        $user->save();

        return response()->json(['message' => 'Usuario desativado', 'user' => $user]);
    }
}
