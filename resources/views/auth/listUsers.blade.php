@extends('layouts.app')

@section('header-intro')

    <h2 style="text-align: center;">@section('title', 'Listando os Usuários')</h2>

@endsection

@section('conteudo')
    <style>
        @media (max-width: 767px) {
            .table thead {
                display: none;
            }

            .table td {
                display: flex;
                justify-content: space-between;
            }

            .table tr {
                display: block;
            }

            .table td:first-of-type {
                font-weight: bold;
                font-size: 1.2rem;
                text-align: center;
                display: block;
            }

            .table td:not(:first-of-type):before {
                content: attr(data-title);
                display: block;
                font-weight: bold;
            }
        }
    </style>

    <div class="col-md-10  mx-auto justify-content-center align-items-center flex-column">
        <div class="col-md-12 mx-auto justify-content-center align-items-center flex-column">
            <table class="table table-striped table-md">
                <div class="table-responsive">
                    <thead>
                    <tr style='text-align:center;'>
                        <th>Nome</th>
                        <th>Email</th>
                        <th style='text-align:right;'>Ações</th>
                    </tr>
                    </thead>
                    <tbody style='text-align:center;'>
                    @foreach ($users as $user)
                        <tr>
                            <td class='fw-bold'>{{ $user->name }}</td>
                            <td data-title='email'>{{ $user->email }}</td>
{{--                            <td data-title="Ações" style='text-align:right;'>--}}
{{--                                <a href='{{ route('edituser.index', $user->id) }}'><button type='button'--}}
{{--                                                                                                     class='btn btn-sm btn-warning'>Editar</button></a>--}}

{{--                                <form action="{{ route('destroy.user', $user->id) }}" method="post"--}}
{{--                                      style="display:inline-block;">--}}
{{--                                    @csrf--}}
{{--                                    @method('delete')--}}
{{--                                    <button type="submit" class="btn btn-sm btn-danger"--}}
{{--                                            value="excluir">Excluir</button>--}}
{{--                                </form>--}}
                            <td data-title="Ações" style='text-align:right;'>
                                <a href='{{ route("edituser.index", $user->id) }}'>
                                    <button type='button' class='btn btn-sm btn-warning'>Editar</button>
                                </a>

                                <button type="button" class="btn btn-sm btn-danger btn-delete" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-userid="{{ $user->id }}">Excluir</button>
                            </td>
                    @endforeach
                    </tbody>
                </div>
            </table>
            @if (count($users) == 0)
                <p style="text-align: center;"> Não existe usuários cadastrados no sistema</p>
            @endif
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir este usuário, ao excluir ele excluirá todos os posts que o mesmo criou?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteUserForm" action="#" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Captura o evento de clique no botão de excluir e atualiza o formulário com a rota correta
        document.querySelectorAll('.btn-delete').forEach(function (button) {
            button.addEventListener('click', function () {
                var userId = this.dataset.userid; // Obtém o ID do usuário a ser excluído
                var form = document.getElementById('deleteUserForm');
                var url = '{{ route("destroy.user", ":id") }}'; // Rota para exclusão de usuário
                url = url.replace(':id', userId);
                form.setAttribute('action', url); // Define a URL de exclusão no formulário
            });
        });
    </script>





@endsection
