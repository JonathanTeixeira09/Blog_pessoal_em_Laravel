<nav class="navbar navbar-expand-lg bg-body-tertiary rounded fixed-top" aria-label="Thirteenth navbar example">
    <div class="container-fluid">
        <a class="navbar-brand col-lg-3 me-0" href="{{route('home')}}"><img src="{{ URL::to('img/logo.png') }}"
                                                                            alt="Inicio" width="200"
                                                                            height="60"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11"
                aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
            {{--            <a class="navbar-brand col-lg-3 me-0" href="#"><img src="{{ URL::to('img/logo.png') }}" alt="Inicio" width="200" height="60"></a>--}}
            <ul class="navbar-nav col-lg-8 justify-content-lg-center">

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('home')}}">
                        Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('posts')}}">Publicações</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('about')}}">Sobre Mim</a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Administrativo</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('createuser.index')}}">Criar Usuário</a></li>
                            <li><a class="dropdown-item" href="{{ route('listusers.index') }}">Listar Usuários</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{route('formpost')}}">Criar Publicação</a></li>
                            <li><a class="dropdown-item" href="{{ route('listposts.index')}}">Listar Publicações</a>
                            </li>
                        </ul>
                    </li>
                @endauth
                @guest()
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login.index')}}">Login</a>
                    </li>
                @endguest
            </ul>

            <div class="d-lg-flex col-lg-4 justify-content-lg-end">
                <div class="">
                    Bem-vindo
                    @if(auth()->guest())
                        <strong class="strong-custom-users"> Visitante </strong>
                        {{--                        <a href="{{route('login.index')}}">--}}
                        {{--                            <button type="button" class="btn btn-primary me-2">Login</button>--}}
                        {{--                        </a>--}}
                    @else
                        <strong class="strong-custom-users">{{ Auth::user()->name }} </strong> | <a
                            href="{{route('logout')}}" class="link-color">Sair</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>
{{--                            <button type="button" class="btn btn-danger me-2">Sair</button>--}}
