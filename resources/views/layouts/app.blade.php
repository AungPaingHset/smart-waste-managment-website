<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

   
</head>
<body>
    <div id="app" class="vh-100">

        <nav id="glass-navbar" class="navbar navbar-expand-lg sticky scrolled">
            <div class="container justify-content-between">

                <a class="navbar-brand fw-bold " href="{{ url('/') }}">
                    <img src="/asset/main/logo.png" alt="" class="logo-img">
                    <span class="brand-text">{{ config('app.name', 'EcoKyats') }}</span>
                </a>
                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon "></span>
                </button>

                <div class="collapse navbar-collapse " id="navbarSupportedContent">
            
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                        <li class="nav-item">
                            <a class="nav-link  text-center fw-bolder" href="{{'/'}}">Home</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-center fw-bolder" href="{{ url('/ebin')}}" >E-bin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  text-center fw-bolder" href="{{ url('/articles') }}" >Our Community</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item"><a class="nav-link text-center text-black fw-bolder" href="{{ route('login') }}">Login</a></li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item"><a class="nav-link text-center text-black fw-bolder" href="{{ route('register') }}">Register</a></li>
                            @endif
                        @else
                            <li class="nav-item dropdown" >
                                <a class="nav-link dropdown-toggle text-success  text-end  fs-6" href="#" data-bs-toggle="dropdown">
                                    <small>{{ Auth::user()->name }}</small>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end " id="glass-btn">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="my-5">
            @yield('content')
        </main>
    </div>
    

</body>
</html>
