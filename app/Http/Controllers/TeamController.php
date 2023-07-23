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
            ['value' => null, 'label' => 'Sem equipe'], // Option for "Sem equipe" (Without team)
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

        return redirect()->route('teams.index')->with('success', 'Equipe criada com sucesso!');
    }

    public function update(Request $request, Team $team)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'responsible_id' => 'nullable|exists:users,id',
        ]);

        $team->update($validatedData);

        return redirect()->route('teams.index')->with('success', 'Equipe atualizada com sucesso!');
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Equipe excluída com sucesso!');
    }
}