<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

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

        $teams = Team::all(); // Fetch all teams from the database
        $teamOptions = [
            ['value' => null, 'label' => 'Sem equipe'], // Option for "Sem equipe" (Without team)
        ];


        foreach ($teams as $team) {
            $teamOptions[] = [
                'value' => $team->id,
                'label' => $team->name,
            ];
        }

        $adicao = [
            'name' => ['tipo'=>'string','label'=>'Nome'],
            'login' => ['tipo'=>'string','label'=>'Login'],
            'password' => ['tipo'=>'password','label'=>'Senha'],
            'email' => ['tipo'=>'email','label'=>'E-mail'],
            'team_id' => ['tipo' => 'select', 'label' => 'Equipe', 'options' => $teamOptions],
        ];

        $edicao = [
            'name' => ['tipo'=>'string','label'=>'Nome'],
            'login' => ['tipo'=>'string','label'=>'Login'],
            'password' => ['tipo'=>'password','label'=>'Senha'],
            'email' => ['tipo'=>'email','label'=>'E-mail'],
            'team_id' => ['tipo' => 'select', 'label' => 'Equipe', 'options' => $teamOptions],
            'ativo' => ['tipo'=>'boolean','label'=>'Ativo'],
        ];
        $acao = 'Usuario';

        return view('lista', compact('linhas', 'colunas','titulo', 'descricao','adicao','edicao','acao'));
    }
    public function store(Request $request)
    {
        // Defina as regras de validação
        $rules = [
            'name' => 'required|string',
            'login' => 'required|unique:users',
            'password' => 'required',
            'email' => 'required|email|unique:users',
        ];

        // Defina as mensagens de erro personalizadas
        $messages = [
            'name.required' => 'O campo nome é obrigatório.',
            'login.required' => 'O campo login é obrigatório.',
            'login.unique' => 'O login informado já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
        ];

        // Valide os dados de entrada
        $validator = Validator::make($request->all(), $rules, $messages);

        // Verifique se há erros de validação
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar usuário',
                'errors' => $validator->errors()
            ], 400); // Código 400 para indicar requisição inválida
        }

        // Criação do usuário
        User::create($request->all());

        return response()->json(['success' => true ,'message' => 'Usuário criado com sucesso']);
    }
    public function update(Request $request, $id)
    {
        // Defina as regras de validação
        $rules = [
            'name' => 'required|string',
            'login' => 'required|unique:users,login,' . $id,
            'password' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ];

        // Defina as mensagens de erro personalizadas
        $messages = [
            'name.required' => 'O campo nome é obrigatório.',
            'login.required' => 'O campo login é obrigatório.',
            'login.unique' => 'O login informado já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'O e-mail informado já está em uso.',
        ];

        // Valide os dados de entrada
        $validator = Validator::make($request->all(), $rules, $messages);

        // Verifique se há erros de validação
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar usuário',
                'errors' => $validator->errors()
            ], 400); // Código 400 para indicar requisição inválida
        }

        // Atualização do usuário
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json(['message' => 'Usuário atualizado', 'user' => $user]);
    }

    public function deactivate($id)
    {
        // Inativação do usuário
        $user = User::findOrFail($id);
        $user->active = false;
        $user->save();

        return response()->json(['message' => 'Usuário desativado', 'user' => $user]);
    }
}
