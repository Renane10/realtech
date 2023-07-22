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
        $adicao = [
            'name' => ['tipo'=>'string','label'=>'Nome'],
            'login' => ['tipo'=>'string','label'=>'Login'],
            'password' => ['tipo'=>'password','label'=>'Senha'],
            'email' => ['tipo'=>'email','label'=>'E-mail'],
            'team_id' => ['tipo'=>'select','label'=>'Equipe','options'=>
                [
                    ['value'=>1,'label'=>'Equipe 1'],
                    ['value'=>2,'label'=>'Equipe 2'],
                    ['value'=>3,'label'=>'Equipe 3'],
                ]
            ],
        ];
        $edicao = [
            'name' => ['tipo'=>'string','label'=>'Nome'],
            'login' => ['tipo'=>'string','label'=>'Login'],
            'password' => ['tipo'=>'password','label'=>'Senha'],
            'email' => ['tipo'=>'email','label'=>'E-mail'],
            'team_id' => ['tipo'=>'select','label'=>'Equipe','options'=>
                [
                    ['value'=>1,'label'=>'Equipe 1'],
                    ['value'=>2,'label'=>'Equipe 2'],
                    ['value'=>3,'label'=>'Equipe 3'],
                ]
            ],
            'ativo' => ['tipo'=>'boolean','label'=>'Ativo'],
        ];
        return view('lista', compact('linhas', 'colunas','titulo', 'descricao','adicao','edicao'));
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
