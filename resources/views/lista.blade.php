@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>{{ $titulo }}</h2>
        <div class="container d-flex justify-content-between align-items-center mb-4">
            <h6>{{ $descricao }}</h6>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                Adicionar Usuário
            </button>
        </div>

        <!-- Tabela de modelos -->
        <table class="table">
            <thead>
            <tr>
                @foreach ($colunas as $coluna => $label)
                    <th>{{ $label }}</th>
                @endforeach
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($linhas as $linha)
                <tr>
                    @foreach ($colunas as $coluna => $label)
                        <td>{{ $linha->$coluna }}</td>
                    @endforeach
                    <td>
                        <!-- Botão para editar -->
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModelModal{{ $linha->id }}">
                            Editar
                        </button>

                        <!-- Botão para inativar -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#inactivateModelModal{{ $linha->id }}">
                            Inativar
                        </button>
                    </td>
                </tr>
                <!-- Modal para editar modelo -->
                <div class="modal fade" id="editModelModal{{ $linha->id }}" tabindex="-1" role="dialog" aria-labelledby="editModelModalLabel{{ $linha->id }}" aria-hidden="true">
                    <!-- Conteúdo do modal de edição -->
                    <!-- Restante do código da modal de edição... -->
                </div>
                <!-- Modal para inativar modelo -->
                <div class="modal fade" id="inactivateModelModal{{ $linha->id }}" tabindex="-1" role="dialog" aria-labelledby="inactivateModelModalLabel{{ $linha->id }}" aria-hidden="true">
                    <!-- Conteúdo do modal de inativação -->
                    <!-- Restante do código da modal de inativação... -->
                </div>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
