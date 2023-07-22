@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>{{ $titulo }}</h2>
        <div class="container d-flex justify-content-between align-items-center mb-4">
            <h6>{{ $descricao }}</h6>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModelModal">
                Adicionar
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
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModelModalLabel{{ $linha->id }}">Editar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulário de edição -->
                                <form method="POST" action="{{ route('editUsuario', ['id' => $linha->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    @foreach ($edicao as $campo => $config)
                                        <div class="form-group">
                                            @if ($config['tipo'] === 'select')
                                                <label for="{{ $campo }}">{{ $config['label'] }}</label>
                                                <select class="form-control" id="{{ $campo }}" name="{{ $campo }}">
                                                    @foreach ($config['options'] as $option)
                                                        <option value="{{ $option['value'] }}" {{ $linha->$campo == $option['value'] ? 'selected' : '' }}>
                                                            {{ $option['label'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @elseif ($config['tipo'] === 'boolean')
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="{{ $campo }}" name="{{ $campo }}" {{ $linha->$campo ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="{{ $campo }}">
                                                        {{ $config['label'] }}
                                                    </label>
                                                </div>
                                            @else
                                                <label for="{{ $campo }}">{{ $config['label'] }}</label>
                                                <input type="{{ $config['tipo'] }}" class="form-control" id="{{ $campo }}" name="{{ $campo }}" value="{{ $linha->$campo }}" required>
                                            @endif
                                        </div>
                                    @endforeach
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal para inativar modelo -->
                <!-- Modal para inativar modelo -->
                <div class="modal fade" id="inactivateModelModal{{ $linha->id }}" tabindex="-1" role="dialog" aria-labelledby="inactivateModelModalLabel{{ $linha->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="inactivateModelModalLabel{{ $linha->id }}">Inativar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Mensagem de confirmação -->
                                <p>Deseja realmente inativar o usuário "{{ $linha->name }}"?</p>
                            </div>
                            <div class="modal-footer">
                                <!-- Botão para cancelar a ação -->
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <!-- Botão para confirmar a inativação -->
                                <form method="POST" action="{{ route('delUsuario', ['id' => $linha->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Inativar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
            <!-- Modal de adição -->
            <div class="modal fade" id="addModelModal" tabindex="-1" role="dialog" aria-labelledby="addModelModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModelModalLabel">Adicionar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulário de adição -->
                            <form method="POST" action="{{ route('addUsuario') }}">
                                @csrf
                                @foreach ($adicao as $campo => $config)
                                    <div class="form-group">
                                        <label for="{{ $campo }}">{{ $config['label'] }}</label>
                                        @if ($config['tipo'] === 'select')
                                            <select class="form-control" id="{{ $campo }}" name="{{ $campo }}">
                                                @foreach ($config['options'] as $option)
                                                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="{{ $config['tipo'] }}" class="form-control" id="{{ $campo }}" name="{{ $campo }}" required>
                                        @endif
                                    </div>
                                @endforeach

                                <!-- Outros campos do formulário -->

                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </form>
                        </div>
                    </div>
            </tbody>
        </table>
    </div>

    <!-- Modal de adição -->
    <!-- Código da modal de adição... -->
@endsection
