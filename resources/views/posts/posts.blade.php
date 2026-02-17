@extends('layouts.app')

@section('header-intro')
    <h2 style="text-align: center;">@section('title', 'Posts '. '(' .$posts->total() . ')')</h2>
@endsection

@section('conteudo')

    <!-- Blog entries-->
    <div class="col-lg-12">
        <div class="row mb-4 justify-content-md-center">
            <div class="col col-lg-6">
                <form class="d-flex" role="search" method="get" action="{{route('home')}}">
                    <input class="form-control me-2" type="search" placeholder="Qual post você deseja buscar?"
                           aria-label="Search" name="busca" value="{{ request()->input('busca') ?? '' }}">
                    <button class="btn btn-outline-custom" type="submit">Buscar</button>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse($posts as $post)
                <div class="col-md-6 mb-1">
                    <!-- Blog post-->
                    <div class="card mb-4">
                        <a href="{{route('post',$post->slug)}}"><img class="card-img-top"
                                                                     src="{{ URL::to("storage/{$post->thumbnail}") }}"
                                                                     alt="{{$post->title}}" width="700"
                                                                     height="350"/></a>
                        <div class="card-body">
                            <div class="small text-muted">{{$post->created_at->format('F/y')}}</div>
                            <h2 class="card-title h4">{{$post->title}}</h2>
                            <p class="card-text">{{Str::limit(html_entity_decode(strip_tags($post->content)), 50, '...') }}</p>
                            <p>
                                <strong><img src="{{ URL::to('img/icons/person-circle.svg') }}" width="20" height="20" class="mb-1"> </strong> {{$post->user->name}}
                                <strong>&nbsp&nbsp<img src="{{ URL::to('img/icons/chat-heart.svg') }}" width="20" height="20" class="mb-1"> </strong> {{$post->comments->count()}}
                                <strong>&nbsp&nbsp<img src="{{ URL::to('img/icons/eye.svg') }}" width="20" height="20" class="mb-1"> </strong> {{ $post->views_count }}
                            </p>
                            <a class="btn btn-primary" href="{{route('post',$post->slug)}}"
                               style="background-color: #F44B90; border-color: #F44B90;">Leia mais →</a>
                        </div>
                    </div>
                </div>
            @empty
                <h4>
                    <center>Sem publicações no momento. Verifique novamente mais tarde.</center>
                </h4>
            @endforelse

        </div>
        <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div>

    </div>

@endsection
