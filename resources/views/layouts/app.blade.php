<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark navbar-keyshare bg-dark fixed-top">
            <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            @guest
            @else
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="./viewuser.php?id=" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ Auth::user()->image }}" height="25px" width="25px"> {{ Auth::user()->name }}

                            @php( $i = Auth::user()->getKarma() )
                            @if ($i < 0)
                                <span class="badge badge-pill badge-danger"> {{$i}} </span>
                            @elseif ($i < 2)
                                <span class="badge badge-pill badge-warning"> {{$i}} </span>
                            @elseif ($i < 15 )
                                <span class="badge badge-pill badge-info"> {{$i}} </span>
                            @else
                                <span class="badge badge-pill badge-success"> {{$i}} </span>
                            @endif

                        </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/users/{{auth()->id()}}">{{ __('nav.viewprofile') }}</a>
                                <a class="dropdown-item" href="{{ route('edituser') }}">{{ __('nav.updateprofile') }}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('claimedkeys') }}">{{ __('nav.claimedkeys') }}</a>
                                <a class="dropdown-item" href="{{ route('sharedkeys') }}">{{ __('nav.sharedkeys') }}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('changepassword') }}">{{ __('nav.changepassword') }}</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('games') }}">{{ __('games.games') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('addkey') }}">{{ __('nav.addkey') }}</a>
                    </ul>

                    <form class="form-inline my-2 my-lg-0" method="get" action="{{ route('search') }}">
                        <game-autocomplete placeholder="{{ __('nav.search') }}..." name="search" id="search" type="search" classes="form-control mr-sm-2"></game-autocomplete>
                        <button class="btn btn-outline-primary btn-outline-keyshare my-2 my-sm-0" type="submit">{{ __('nav.search') }}</button>
                    </form>
                </div>
            @endif
        </nav>

        <div class="jumbotron">
            <img src="{{ asset('images/LogoWeb.png') }}" alt="360NoHope" width="137" height="110">
        </div>

        <title-header title="@yield('header')"></title-header>

        @yield('content')
</body>
</html>
