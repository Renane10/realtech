@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>{{ $titulo }}</h2>
        <div class="container d-flex justify-content-between align-items-center mb-4">
            <h6>{{ $descricao }}</h6>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModelModal">
                Adicionar {{$acao}}
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
                        @if($coluna == 'icone')
                            <td><i class="{{ $linha->icone }}" style="color: {{$linha->cor}}"></i></td>
                        @else
                            <td>{{ $coluna }}</td>
                        @endif
                    @endforeach
                    <td>
                        <!-- Botão para editar -->
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModelModal{{ $linha->id }}">
                            Editar
                        </button>

                        <!-- Botão para deletar -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#inactivateModelModal{{ $linha->id }}">
                            Deletar
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
                                <form method="POST" action="{{ route('edit' . $acao, ['id' => $linha->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    @foreach ($edicao as $campo => $config)
                                        <div class="form-group">
                                            <label for="edit_{{ $campo }}">{{ $config['label'] }}</label>
                                            @if ($config['tipo'] === 'select')
                                                <select class="form-control" id="edit_{{ $campo }}" name="{{ $campo }}">
                                                    @foreach ($config['options'] as $option)
                                                        <option value="{{ $option['value'] }}" {{ $linha->$campo == $option['value'] ? 'selected' : '' }}>
                                                            {{ $option['label'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @elseif ($config['tipo'] === 'cor')
                                                <input type="color" class="form-control" id="edit_{{ $campo }}" name="{{ $campo }}" value="{{ $linha->$campo }}">
                                            @elseif($config['tipo'] === 'icone')
                                                <div class="icon-radio">
                                                    <input type="radio" name="icone" value="fas fa-star" id="icone-star-edit">
                                                    <label for="icone-star-edit"><i class="fas fa-star"></i></label>

                                                    <input type="radio" name="icone" value="fas fa-heart" id="icone-heart-edit">
                                                    <label for="icone-heart-edit"><i class="fas fa-heart"></i></label>

                                                    <input type="radio" name="icone" value="fas fa-bell" id="icone-bell-edit">
                                                    <label for="icone-bell-edit"><i class="fas fa-bell"></i></label>

                                                    <input type="radio" name="icone" value="fa fa-address-book" id="icone-adress-edit">
                                                    <label for="icone-adress-edit"><i class="fa fa-address-book"></i></label>

                                                    <input type="radio" name="icone" value="fa fa-times" id="icone-times-edit">
                                                    <label for="icone-times-edit"><i class="fa fa-times"></i></label>

                                                    <input type="radio" name="icone" value="fa fa-arrow-left" id="icone-arrow-right-left-edit">
                                                    <label for="icone-left-edit"><i class="fa fa-arrow-left"></i></label>

                                                    <input type="radio" name="icone" value="fa fa-arrow-right" id="icone-arrow-right-edit">
                                                    <label for="icone-arrow-right-edit"><i class="fa fa-arrow-right"></i></label>

                                                    <input type="radio" name="icone" value="fa fa-undo" id="icone-undo-edit">
                                                    <label for="icone-undo-edit"><i class="fa fa-undo"></i></label>

                                                    <input type="radio" name="icone" value="fa fa-money" id="icone-money-edit">
                                                    <label for="icone-money-edit"><i class="fa fa-money"></i></label>

                                                    <input type="radio" name="icone" value="fa fa-envelope" id="icone-envelope-edit">
                                                    <label for="icone-envelope-edit"><i class="fa fa-envelope"></i></label>
                                                </div>
                                            @else
                                                <input type="{{ $config['tipo'] }}" class="form-control" id="edit_{{ $campo }}" name="{{ $campo }}" value="{{ $linha->$campo }}" required>
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
                                <p>Deseja realmente DELETAR o {{$acao}}?</p>
                            </div>
                            <div class="modal-footer">
                                <!-- Botão para cancelar a ação -->
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <!-- Botão para inativar -->
                                <button type="button" class="btn btn-danger btn-inativar" data-route="{{ route('del' . $acao, ['id' => $linha->id]) }}">
                                    Inativar
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
    </div>

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
                    <form id="addForm">
                        @csrf
                        @foreach ($adicao as $campo => $config)
                            <div class="form-group">
                                <label for="add_{{ $campo }}">{{ $config['label'] }}</label>
                                @if ($config['tipo'] === 'select')
                                    <select class="form-control" id="add_{{ $campo }}" name="{{ $campo }}">
                                        @foreach ($config['options'] as $option)
                                            <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                        @endforeach
                                    </select>
                                @elseif($config['tipo'] === 'cor')
                                    <input type="color" class="form-control" id="add_{{ $campo }}" name="{{ $campo }}" value="#000000">
                                @elseif($config['tipo'] === 'icone')
                                    <div class="icon-radio">
                                        <input type="radio" name="icone" value="fas fa-star" id="icone-star">
                                        <label for="icone-star"><i class="fas fa-star"></i></label>

                                        <input type="radio" name="icone" value="fas fa-heart" id="icone-heart">
                                        <label for="icone-heart"><i class="fas fa-heart"></i></label>

                                        <input type="radio" name="icone" value="fas fa-bell" id="icone-bell">
                                        <label for="icone-bell"><i class="fas fa-bell"></i></label>

                                        <input type="radio" name="icone" value="fa fa-address-book" id="icone-adress">
                                        <label for="icone-adress"><i class="fa fa-address-book"></i></label>

                                        <input type="radio" name="icone" value="fa fa-times" id="icone-times">
                                        <label for="icone-times"><i class="fa fa-times"></i></label>

                                        <input type="radio" name="icone" value="fa fa-arrow-left" id="icone-arrow-right-left">
                                        <label for="icone-left"><i class="fa fa-arrow-left"></i></label>

                                        <input type="radio" name="icone" value="fa fa-arrow-right" id="icone-arrow-right">
                                        <label for="icone-arrow-right"><i class="fa fa-arrow-right"></i></label>

                                        <input type="radio" name="icone" value="fa fa-undo" id="icone-undo">
                                        <label for="icone-undo"><i class="fa fa-undo"></i></label>

                                        <input type="radio" name="icone" value="fa fa-money" id="icone-money">
                                        <label for="icone-money"><i class="fa fa-money"></i></label>

                                        <input type="radio" name="icone" value="fa fa-envelope" id="icone-envelope">
                                        <label for="icone-envelope"><i class="fa fa-envelope"></i></label>
                                    </div>
                                @else
                                    <input type="{{ $config['tipo'] }}" class="form-control" id="add_{{ $campo }}" name="{{ $campo }}" required>
                                @endif
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Função para exibir um toast de sucesso
        function showSuccessToast(message) {
            toastr.success(message);
        }

        // Função para exibir um toast de erro
        function showErrorToast(message) {
            toastr.error(message);
        }

        // Evento DOMContentLoaded para carregar o código após o carregamento da página
        document.addEventListener('DOMContentLoaded', function () {
            $('.icon-radio input[type="radio"]').change(function() {
                const selectedIcon = $(this).val();
                $('#hidden-icon').val(selectedIcon);
            });
            // Evento para submeter o formulário de adição via AJAX
            $('#addForm').submit(function (event) {
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        // Exibe o toast de sucesso com a mensagem retornada pelo servidor
                        showSuccessToast(response.message);

                        // Fecha o modal de adição
                        $('#addModelModal').modal('hide');

                        // Recarrega a página para atualizar a tabela
                        location.reload();
                    },
                    error: function (error) {
                        // Exibe o toast de erro com a mensagem de erro retornada pelo servidor
                        showErrorToast(error.responseJSON.message);
                    }
                });
            });

            // Ajax para edição
            $('form[id^="editForm"]').submit(function (event) {
                event.preventDefault();

                var form = $(this); // Salvando a referência ao formulário em uma variável

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function (response) {
                        // Exibe o toast de sucesso com a mensagem retornada pelo servidor
                        showSuccessToast(response.message);

                        // Fecha o modal de edição usando a variável "form"
                        form.closest('.modal').modal('hide');

                        // Recarrega a página para atualizar a tabela
                        location.reload();
                    },
                    error: function (error) {
                        // Exibe o toast de erro com a mensagem de erro retornada pelo servidor
                        showErrorToast(error.responseJSON.message);
                    }
                });
            });
                // Evento para enviar a requisição de inativação via AJAX
            $('.btn-inativar').click(function () {
                const route = $(this).data('route');

                $.ajax({
                    url: route,
                    type: 'DELETE',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (response) {
                        // Exibe o toast de sucesso com a mensagem retornada pelo servidor
                        showSuccessToast(response.message);

                        // Recarrega a página para atualizar a tabela
                        location.reload();
                    },
                    error: function (error) {
                        // Exibe o toast de erro com a mensagem de erro retornada pelo servidor
                        showErrorToast(error.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endsection
<style>
    .icon-radio input[type="radio"] {
        display: none;
    }

    .icon-radio label {
        display: inline-block;
        font-size: 24px;
        padding: 10px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    .icon-radio input[type="radio"]:checked + label {
        background-color: #007bff;
        color: white;
    }

</style>
