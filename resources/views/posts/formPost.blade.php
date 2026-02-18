@extends('layouts.app')

@section('title', 'Criando uma Publicação')
@section('conteudo')
    @push('tinyMCE')
            @vite(['resources/js/app.js'])
    @endpush

    <div class="col-lg-12">
        <form action="{{route('formpost')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Título do Post</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                       placeholder="informe o nome do título de sua postagem" value="{{ old('title')}}">
                <div class="invalid-feedback">
                    @error('title')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Carregar Thumbnail do Post</label>
                <input class="form-control @error('thumbnail') is-invalid @enderror" type="file" accept="image/*" name="thumbnail" value="{{ old('thumbnail')}}">
                <div class="invalid-feedback">
                    @error('thumbnail')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            {{--            Teste de Inicio de Select--}}
            <div class="mb-3">
                <label for="selectOption" class="form-label">Selecione uma opção:</label>
                <select class="form-select" id="selectOption" name="selectOption">
                    <option value="selecione">Selecione</option>
                    <option value="video">Carregar Link de Video</option>
                    <option value="upload">Carregar Foto para Post</option>
                </select>
            </div>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger messageBox mb-3" role="alert">
                        @error('linkVideo')
                        {{ $message }}
                        @enderror

                    </div>
                @endforeach
            @endif

            <div class="mb-3" id="uploadField" style="display: none;">
                <label for="fileInput" class="form-label">Carregar imagem do Post:</label>
                <input type="file" class="form-control @error('imagePost') is-invalid @enderror" id="fileInput" name="imagePost" value="{{ old('imagePost')}}">
                <div class="invalid-feedback">
                    @error('imagePost')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="mb-3" id="infoField" style="display: none;">
                <label for="infoInput" class="form-label">Link do vídeo para o Post:</label>
                <input type="text" class="form-control @error('linkVideo') is-invalid @enderror" id="infoInput" name="linkVideo"
                       placeholder="Cole aqui o Link do vídeo" value="{{ old('linkVideo')}}">
                <div class="invalid-feedback">
                    @error('linkVideo')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Texto do Post</label>
                <textarea class="tinyMce @error('content') is-invalid @enderror" name="content" rows="5" value="{{ old('content')}}"></textarea>
                <div class="invalid-feedback">
                    @error('content')
                    {{ $message }}
                    @enderror
                </div>

            </div>

            <div class="mb-3">
                <label class="form-label">Upload de Arquivos para Post: </label>
                <input class="form-control @error('uploadArquivo') is-invalid @enderror" type="file" name="uploadArquivo" value="{{ old('uploadArquivo')}}">
                <div class="invalid-feedback">
                    @error('uploadArquivo')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <p style="text-align: right;">
                    <button type="submit" class="btn btn-primary btn-block" value="cadastrar">Publicar Post
                    </button>
                </p>
            </div>
        </form>

    </div>

@endsection
@push('script')
    <script>
        document.getElementById('selectOption').addEventListener('change', function () {
            var uploadField = document.getElementById('uploadField');
            var infoField = document.getElementById('infoField');

            if (this.value === 'upload') {
                uploadField.style.display = 'block';
                infoField.style.display = 'none';
            } else if (this.value === 'video') {
                uploadField.style.display = 'none';
                infoField.style.display = 'block';
            }
        });

        // .. After imports init TinyMCE ..
        window.addEventListener('DOMContentLoaded', () => {
            tinymce.init({
                selector: 'textarea',

                /* TinyMCE configuration options */
                skin: false,
                content_css: false
            });
        });

    </script>
@endpush
