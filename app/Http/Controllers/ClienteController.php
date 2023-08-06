<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index()
    {
        $linhas = Cliente::all();
        $titulo = 'Gerenciamento de Clientes';
        $descricao = 'Aqui você pode cadastrar, editar e inativar os clientes do sistema';

        // Configuração das colunas da tabela
        $colunas = [
            'nome' => 'Nome',
            'email' => 'E-mail',
            'cpf_cnpj' => 'CPF/CNPJ',
            'status' => 'Status',
        ];

        // Obter usuários para criar as opções do campo "Status"
        $usuariosResponsaveis = User::all(['id', 'name']);
        $userOptions = [
            ['value' => true, 'label' => 'Ativo'],
            ['value' => false, 'label' => 'Inativo'],
        ];

        $adicao = [
            'nome' => ['tipo' => 'string', 'label' => 'Nome'],
            'email' => ['tipo' => 'email', 'label' => 'E-mail'],
            'cpf_cnpj' => ['tipo' => 'string', 'label' => 'CPF/CNPJ'],
            'status' => ['tipo' => 'select', 'label' => 'Status', 'options' => $userOptions],
        ];

        $edicao = [
            'nome' => ['tipo' => 'string', 'label' => 'Nome'],
            'email' => ['tipo' => 'email', 'label' => 'E-mail'],
            'cpf_cnpj' => ['tipo' => 'string', 'label' => 'CPF/CNPJ'],
            'status' => ['tipo' => 'select', 'label' => 'Status', 'options' => $userOptions],
        ];

        $acao = 'Cliente';

        return view('lista', compact('linhas', 'colunas', 'titulo', 'descricao', 'adicao', 'acao', 'edicao'));
    }

    public function store(Request $request)
    {
        // Validar os dados do cliente
        $validatedData = $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email',
            'cpf_cnpj' => 'required|string',
            'status' => 'required|boolean',
        ]);

        // Obter o ID do usuário autenticado
        $userId = Auth::id();
        // Adicionar o ID do usuário autenticado aos dados validados
        $validatedData['usuario_criacao'] = $userId;

        // Criar o cliente
        Cliente::create($validatedData);

        return response()->json(['success' => true ,'message' => 'Cliente criado com sucesso!']);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email',
            'cpf_cnpj' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['success' => false ,'message' => 'Cliente não encontrado'], 404);
        }

        $cliente->update($validatedData);

        return response()->json(['success' => true ,'message' => 'Cliente atualizado com sucesso!']);
    }

    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['success' => false ,'message' => 'Cliente não encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['success' => true ,'message' => 'Cliente excluído com sucesso!']);
    }

}
