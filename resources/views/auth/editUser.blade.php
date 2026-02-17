@extends('layouts.app')

@section('header-intro')

    <h2 style="text-align: center;">@section('title', 'Editando o Usuário: '.$users->name)</h2>

@endsection

@section('conteudo')

    <div class="col-lg-12">
        <form action="{{route('updateuser', $users->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nome:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                       placeholder="Nome" value="{{$users->name}}">
                <div class="invalid-feedback">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                       placeholder="Email" value="{{$users->email}}">
                <div class="invalid-feedback">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Senha:</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                       placeholder="Password">
                <div class="invalid-feedback">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Carregar thumbnail do usuário:</label>
                <input class="form-control @error('thumbnail') is-invalid @enderror" type="file" name="thumbnail"
                       value="{{$users->thumbnail}}">
                <div class="invalid-feedback">
                    @error('thumbnail')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <p style="text-align: right;">
                    <button type="submit" class="btn btn btn-success btn-block" value="cadastrar">Editar Usuário
                    </button>
                </p>
            </div>
        </form>
    </div>

@endsection
