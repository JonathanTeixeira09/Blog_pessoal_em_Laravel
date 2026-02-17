@extends('layouts.app')

@section('title', 'Criando Usuário')
@section('conteudo')

    <div class="col-lg-12">
        <form action="{{route('createuser.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nome:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                       placeholder="Nome" value="{{ old('name')}}">
                <div class="invalid-feedback">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                       placeholder="Email" value="{{ old('email')}}">
                <div class="invalid-feedback">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Senha:</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                       placeholder="Password" value="{{ old('password')}}">
                <div class="invalid-feedback">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Carregar thumbnail do usuário:</label>
                <input class="form-control @error('thumbnail') is-invalid @enderror" type="file" name="thumbnail" value="{{ old('thumbnail')}}">
                <div class="invalid-feedback">
                    @error('thumbnail')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <p style="text-align: right;">
                    <button type="submit" class="btn btn btn-primary btn-block" value="cadastrar">Criar Usuário
                    </button>
                </p>
            </div>
        </form>
    </div>

@endsection
