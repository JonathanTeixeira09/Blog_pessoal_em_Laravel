@extends('layouts.app')

@section('title', $title)
@section('conteudo')

    <div class="container-fluid">
        <!-- Video ou Foto -->
        <div class="container-sm text-center">
            <div class="row mb-4 justify-content-md-center">
                <div class="ratio ratio-16x9">
                    @if (!empty($post->linkVideo))
                        {{-- Se há um link de vídeo, exibir o vídeo --}}
                        <iframe width="560" height="315" src="{{ $post->linkVideo }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                    @elseif (!empty($post->imagePost))
                        {{-- Se há uma imagem, exibir a imagem --}}
                        <img class="img-fluid" src="{{ URL::to("storage/{$post->imagePost}") }}"
                             alt="{{ $post->title }}">
                    @endif
                </div>

            </div>
        </div>

        <!-- Data e Nome do Autor -->
        <br>
        <div class="row">
            <div class="col-md-12 ">
                <img src="{{ URL::to("storage/{$post->user->thumbnail}") }}" alt="{{$post->user->name}}" class="rounded-circle me-2" style="width: 50px; height: 50px;">
                <span class="text-muted"><strong>Autor: </strong>{{$post->user->name}}</span>
                <span class="text-muted"><strong>Data:</strong> {{ $post->created_at->format('d \d\e F \d\e Y') }}</span>
                <br>
            </div>
        </div>
        <br>

        <!-- Descrição do Vídeo -->
        <div class="col-lg-12">
            {!!$post->content!!}
            <br>
            <br>

        </div>

        <!-- upload de Arquivos -->
        <div class="container-sm text-center">
            <div class="row mb-4 justify-content-md-center">

                @if ('NULL' !== $post->uploadArquivo)
                    <a class="btn btn-lg btn-primary" href="{{ URL::to("storage/{$post->uploadArquivo}") }}" target="_blank"> Baixar Arquivo</a>
                @else

                @endif

            </div>
        </div>
        <!-- Formulário de Comentários -->

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">

                    <!-- Área de Comentários -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                @if(auth()->user())
                                    <img src="{{ asset('storage/' . session('user_thumbnail')) }}" class="rounded me-3 img-thumbnail" alt="Avatar" width="60" height="60">
                                @else
                                    <img src="{{URL::to('img/users/avatarAnonimo.png')}}" class="rounded me-3 img-thumbnail" alt="Avatar" width="60" height="60">
                                @endif

                                <h5 class="mb-0">Quer participar?</h5>
                            </div>

                            <!-- Formulário de Comentários -->
                            <form action="{{ route('comment',$post->id) }}" method="post">
                                @csrf
                                {{--                                    <input type="hidden" name="post_id" value="{{$post->id}}">--}}

                                @if(auth()->user())
                                    <div class="mb-3">
                                        <input type="hidden" class="form-control @error('name') is-invalid @enderror"
                                               name="name"
                                               placeholder="Nos diga o seu nome!" value="{{ Auth::user()->name }}">

                                        <div class="invalid-feedback">
                                            @error('name')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden" class="form-control @error('email') is-invalid @enderror"
                                               name="email"
                                               placeholder="Informe seu email"
                                               value="{{ Auth::user()->email }}">

                                        <div class="invalid-feedback">
                                            @error('email')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>

                                @else

                                    <div class="mb-3">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               name="name"
                                               placeholder="Nos diga o seu nome!" value="{{ old('name')}}">

                                        <div class="invalid-feedback">
                                            @error('name')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               name="email"
                                               placeholder="Informe seu email"
                                               value="{{ old('email')}}">

                                        <div class="invalid-feedback">
                                            @error('email')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    {{--                                    <label for="comment" class="form-label">Comentário</label>--}}
                                    <textarea class="form-control @error('content') is-invalid @enderror""
                                    name="content" rows="3"
                                    placeholder="Rápido, pense em algo para dizer!"></textarea>

                                    <div class="invalid-feedback">
                                        @error('content')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit">Comentar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Espaço para Exibir Comentários -->

        <div class="container">
            <h3>Comentários</h3>
            @if(session()->has('error_created_comment'))
                <span>{{session()->get('error_created_comment')}}</span>
                ))
            @endif

            @forelse($post->comments as $comment)
                <div class="mt-2 text-bg-light rounded">
                    <div class="row bg-gradient">
                        <div class="col-md-1">
                            @if(empty($comment->user->thumbnail))
                                <!-- Se o caminho da thumbnail estiver vazio, exibe a imagem padrão do usuário que comentou -->
                                <img src="{{URL::to('img/users/avatarAnonimo.png')}}" alt="Avatar" class="img-fluid align-self-start img-thumbnail" width="100" height="100">
                            @else
                                <!-- Se o caminho da thumbnail não estiver vazio, exibe a thumbnail do usuário -->
                                <img src="{{ asset('storage/' . $comment->user->thumbnail) }}" alt="{{$comment->user->name}}" class="img-fluid align-self-start img-thumbnail" width="100" height="100">
                            @endif

                        </div>
                        <div class="col-md-11 d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">{{$comment->name}}</h6>
                                <!-- Mostrar email para conta administradora -->
                                @if(auth()->guest())
                                @else
                                    <p class="mb-0 small"><strong>{{$comment->email}}</strong></p>
                                @endif
                                <!-- FIM -->
                                <p class="mb-0 small text-muted">{{ $comment->created_at->diffForHumans() }}</p>
                                <p class="mb-0">{!! $comment->content !!}</p>
                                @if(auth()->guest())
                                @else
{{--                                    <p class="mb-0"><a class="link-color" href="{{ route('comment.destroy', $comment->id) }}">Excluir</a></p>--}}
                                    <a href="#" class="link-color" onclick="openConfirmationModal('{{ route('comment.destroy', ['comment' => $comment->id]) }}')">Excluir</a>

                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3">
                    Nenhum comentário para esse post.
                </div>
            @endforelse

        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir este comentário?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                    <form id="deleteCommentForm" method="post" action="#">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Sim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openConfirmationModal(route) {
            var deleteForm = document.getElementById('deleteCommentForm');
            deleteForm.action = route;
            var myModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            myModal.show();
        }
    </script>



@endsection
