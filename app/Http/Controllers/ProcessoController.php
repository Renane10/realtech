<?php

namespace App\Http\Controllers;

use App\Models\Processo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProcessoController extends Controller
{
    public function index()
    {
        $linhas = Processo::with('cliente')->get();

        $titulo = 'Gerenciamento de Processos';
        $descricao = 'Aqui você pode visualizar, criar, editar e inativar os processos do sistema';

        // Configuração das colunas da tabela
        $colunas = [
            'numero' => 'Número',
            'cliente.nome' => 'Cliente',
            'status_inicial' => 'Status Inicial',
            'status_atual' => 'Status Atual',
            'ativo' => 'Ativo',
        ];

        $adicao = [
            'numero' => ['tipo' => 'string', 'label' => 'Número'],
            'cliente_id' => ['tipo' => 'select', 'label' => 'Cliente', 'options' => []], // Preencher as opções dinamicamente
            'status_inicial' => ['tipo' => 'string', 'label' => 'Status Inicial'],
            'status_atual' => ['tipo' => 'string', 'label' => 'Status Atual'],
            'ativo' => ['tipo' => 'boolean', 'label' => 'Ativo'],
        ];

        $edicao = [
            'numero' => ['tipo' => 'string', 'label' => 'Número'],
            'cliente_id' => ['tipo' => 'select', 'label' => 'Cliente', 'options' => []], // Preencher as opções dinamicamente
            'status_inicial' => ['tipo' => 'string', 'label' => 'Status Inicial'],
            'status_atual' => ['tipo' => 'string', 'label' => 'Status Atual'],
            'ativo' => ['tipo' => 'boolean', 'label' => 'Ativo'],
        ];

        $acao = 'Processo';

        return view('lista', compact('linhas', 'colunas', 'titulo', 'descricao', 'adicao', 'acao', 'edicao'));
    }


    public function store(Request $request)
    {
        // Adicione as validações de acordo com os campos da tabela de processos
        $validator = Validator::make($request->all(), [
            // Defina as validações para cada campo
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        Processo::create($request->all());

        return response()->json(['success' => true, 'message' => 'Processo criado com sucesso!']);
    }

    public function update(Request $request, $id)
    {
        $processo = Processo::findOrFail($id);

        // Adicione as validações de acordo com os campos da tabela de processos
        $validator = Validator::make($request->all(), [
            // Defina as validações para cada campo
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $processo->update($request->all());

        return response()->json(['success' => true, 'message' => 'Processo atualizado com sucesso!']);
    }

    public function destroy($id)
    {
        $processo = Processo::findOrFail($id);

        $processo->delete();

        return response()->json(['success' => true, 'message' => 'Processo excluído com sucesso!']);
    }
}
