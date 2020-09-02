<!DOCTYPE html>
<link rel="stylesheet" href="{{ asset('/css/posts.css') }}">
<link rel="stylesheet" href="{{ asset('/css/common.css') }}">
<link rel="shortcut icon" href="{{ secure_asset('icon/favicon.ico') }}">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<!--追加-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--追加-->
<html>

<head>
    <!--追加-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->

    <title>{{ config('app.name')}}｜@yield('title')</title>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: tomato;
        }
    </style>
    <!--追加-->
    <meta charset="UTF-8">
    <link rel="stylesheet" href="example.css">
    <link rel="stylesheet" href="{{ asset('/css/common.css') }}">


    <header>
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto ">
            <!-- Authentication Links -->
            @guest
            @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('SIGNUP') }}</a>
                <a class="nav-link" href="{{ route('login') }}">{{ __('LOGIN') }}</a>
            </li>
            @endif
            @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('LOGOUT') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @endguest
        </ul>

        <nav class="navbar navbar-expand-md  navbar-light bg-light">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#bs-navi" aria-controls="bs-navi" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="bs-navi">
                <ul class="navbar-nav">
                    <li class="nav-list-item"><a class="nav-link" href="{{ action('PostsController@add') }}">POST</a></li>
                    <li class="nav-list-item"><a class="nav-link" href="{{ action('PostsController@show') }}">MYITEMS</a></li>
                    <li class="nav-list-item"><a class="nav-link" href="{{ action('FavoriteController@index') }}">FAVORITE</a></li>
                    <li class="nav-list-item"><a class="nav-link" href="{{ action('TagsController@index') }}">SEARCH</a></li>
                </ul>
            </div>
        </nav>


        <h1 class="headline">
            <p><span class="border-bottom-1"> <a href="{{ action('PostsController@index') }}" class="nav-link">THE AGING</a></span></p>
        </h1>
    </header>
</head>




<body>
    <!-- 各ページでタイトルを個別に表示する -->
    @yield('contents')
</body>


<footer>
    <ul class="footer-menu">
        <li><a href="{{ action('PostsController@add') }}">POST</a>｜</li>
        <li><a href="{{ action('PostsController@show') }}">MYITEMS</a>｜</li>
        <li><a href="{{ action('FavoriteController@index') }}">FAVORITE</a>｜</li>
        <li><a href="{{ action('TagsController@index') }}">SEARCH</a></li>
    </ul>
    <p>© All rights reserved by THE AGING</p>
</footer>


</html>