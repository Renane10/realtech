<?php
<!-- users.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Gerenciamento de Usuários</h2>

        <!-- Botão para adicionar usuário -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
            Adicionar Usuário
        </button>

        <!-- Tabela de usuários -->
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Login</th>
                <th>E-mail</th>
                <th>Equipe</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->login }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->team->name }}</td>
                    <td>
                        <!-- Botão para editar usuário -->
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editUserModal{{ $user->id }}">
                            Editar
                        </button>

                        <!-- Botão para inativar usuário -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#inactivateUserModal{{ $user->id }}">
                            Inativar
                        </button>
                    </td>
                </tr>
                <!-- Modal para editar usuário -->
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                    <!-- Conteúdo do modal -->
                </div>
                <!-- Modal para inativar usuário -->
                <div class="modal fade" id="inactivateUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="inactivateUserModalLabel{{ $user->id }}" aria-hidden="true">
                    <!-- Conteúdo do modal -->
                </div>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- Adicione o botão para abrir a modal de edição -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editUserModal">
        Editar Usuário
    </button>

    <!-- Modal de edição de usuário -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulário de edição de usuário -->
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <!-- Outros campos do formulário -->

                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
