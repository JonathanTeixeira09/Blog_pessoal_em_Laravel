@extends('layouts.app')

@section('header-intro')

    <h2 style="text-align: center;">@section('title', 'Listando Posts')</h2>

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
                        <th>Title</th>
                        <th>Autor</th>
                        <th>Data de Criação</th>
                        <th style='text-align:right;'>Ações</th>
                    </tr>
                    </thead>
                    <tbody style='text-align:center;'>
                    @foreach ($posts as $post)
                        <tr>
                            <td class='fw-bold'>{{ $post->title }}</td>
                            <td data-title='email'>{{ $post->user->name }}</td>
                            <td data-title='email'>{{ date('d/m/Y', strtotime($post->created_at)) }}</td>
                            <td data-title="Ações" style='text-align:right;'>
{{--                                <a href='{{ route('editpost.index', $post->id) }}'>--}}
{{--                                    <button type='button' class='btn btn-sm btn-warning'>Editar</button>--}}
{{--                                </a>--}}

                                <form action="{{ route('destroy.post', $post->id) }}" method="post"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            value="excluir">Excluir
                                    </button>
                                </form>
                    @endforeach
                    </tbody>
                </div>
            </table>
            @if (count($posts) == 0)
                <p style="text-align: center;"> Não existe publicações no sistema</p>
            @endif
        </div>
    </div>

@endsection
