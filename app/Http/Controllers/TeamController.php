<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TeamController extends Controller
{
    public function index()
    {
        $linhas = Team::select('teams.*', 'users.name as responsible_name')
            ->leftJoin('users', 'teams.responsible_id', '=', 'users.id')
            ->get();

        $titulo = 'Gerenciamento de Equipes';
        $descricao = 'Aqui você pode cadastrar, editar e inativar as equipes do sistema';

        // Configuração das colunas da tabela
        $colunas = [
            'name' => 'Nome',
            'description' => 'Descrição',
            'responsible_name' => 'Responsável',
        ];

        // Obter usuários responsáveis para criar as opções do campo "Responsável"
        $usuariosResponsaveis = User::all(['id', 'name']);
        $userOptions = [
            ['value' => null, 'label' => 'Sem Responsável'], // para quando não tiver responsável
        ];

        foreach ($usuariosResponsaveis as $team) {
            $userOptions[] = [
                'value' => $team->id,
                'label' => $team->name,
            ];
        }

        $adicao = [
            'name' => ['tipo' => 'string', 'label' => 'Nome'],
            'description' => ['tipo' => 'string', 'label' => 'Descrição'],
            'responsible_id' => ['tipo' => 'select', 'label' => 'Equipe', 'options' => $userOptions],
        ];

        $edicao = [
            'name' => ['tipo' => 'string', 'label' => 'Nome'],
            'description' => ['tipo' => 'string', 'label' => 'Descrição'],
            'responsible_id' => ['tipo' => 'select', 'label' => 'Equipe', 'options' => $userOptions],
        ];

        $acao = 'Equipe';

        return view('lista', compact('linhas', 'colunas', 'titulo', 'descricao', 'adicao', 'acao', 'edicao'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'responsible_id' => 'nullable|exists:users,id',
        ]);

        Team::create($validatedData);
        return response()->json(['success' => true ,'message' => 'Equipe criada com sucesso!']);
    }

    public function update(Request $request, Team $team)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'responsible_id' => 'nullable|exists:users,id',
        ]);

        $team->update($validatedData);
        return response()->json(['success' => true ,'message' => 'Equipe atualizada com sucesso!']);
    }

    public function destroy($id)
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json(['success' => false, 'message' => 'Equipe não encontrada!']);
        }

        $team->delete();
        return response()->json(['success' => true, 'message' => 'Equipe excluída com sucesso!']);
    }
}