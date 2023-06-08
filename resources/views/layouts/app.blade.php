<!doctype html>
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
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-light">
        <footer class="bg-white">
           {{-- <div class="container py-5">
                <div class="row py-4">
                    <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                        <h6 class="text-uppercase font-weight-bold mb-4">Site</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><a href="{{route('app.home')}}" class="text-muted">Home</a></li>
                            --}}{{--<li class="mb-2"><a href="#" class="text-muted">Register</a></li>
                            <li class="mb-2"><a href="#" class="text-muted">Wishlist</a></li>
                            <li class="mb-2"><a href="#" class="text-muted">Our Products</a></li>--}}{{--
                        </ul>
                    </div>
                </div>
            </div>--}}

            <div class="bg-light py-4">
                <div class="container text-center">
                    <p class="text-muted mb-0 py-2">2023 Diário de um programador</p>
                </div>
            </div>
        </footer>
    </footer>
</div>
</body>
</html>
