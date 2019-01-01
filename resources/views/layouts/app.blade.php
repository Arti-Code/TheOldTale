<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Fallen World') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my_styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body>
<div class="container">
<div class="row">
    <div id="app" class="col col-sm-12 col-md-10 col-lg-8 col-xl-6 mx-auto">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-sm navbar-light bg-light border">
            <div class="container">
                <a class="navbar-brand" href="#"><img src="{{ asset('png/logo.png') }}" height="32" class="d-inline-block align-top" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                                @if (session('char_name') != null)
                                    <li class="nav-item"><a class="nav-link" href="#">{{ Auth::user()->name }} ({{ session('char_name') }})</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('character.myself') }}"><i class="far fa-user"></i></a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('location.show') }}"><i class="fas fa-map-marker-alt"></i></a></li>                                    <li class="nav-item"><a class="nav-link" href="{{ route('message.index') }}"><i class="far fa-comments"></i></a></li>
                                @else
                                    <li class="nav-item"><a class="nav-link" href="#">{{ Auth::user()->name }}</a></li>
                                @endif
                                @if(session("is_admin"))
                                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.universum.index') }}"><i class="fas fa-tools text-warning"></i></a></li>
                                @endif
                                <li class="nav-item"><a class="nav-link" href="{{ route('options.index') }}"><i class="fas fa-cog"></i></a></li>
                            <li class="nav-item">
                                <div>
                                    <a class="nav-link" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt red"></i></a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Alerts -->
        <div class="mt-2">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif
            @if (session('danger'))
                <div class="alert alert-danger">
                    {{ session('danger') }}
                </div>
            @endif
        </div>

        <!-- Main content -->
        <main class="py-4">
            @yield('content')
        </main>


    <!-- Footer -->
    <footer class="page-footer font-small blue">
        <div class="footer-copyright text-center py-5">
            © 2018 Copyright: Artur Gwoździowski
        </div>
    </footer>

    </div> {{-- end app --}}
</div> {{-- end row --}}
</div> {{-- end container --}}

    {{-- Scripts --}}
    <script src="{{ url('js/popper.min.js') }}"></script>
    <script src="{{ url('js/bootstrap.min.js') }}"></script>
    <script>
        $('.dropdown-toggle').dropdown()
    </script>

</body>
</html>
