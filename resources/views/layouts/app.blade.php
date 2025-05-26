<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}?{{ config('commonlandsnet.version') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" integrity="sha256-MeSf8Rmg3b5qLFlijnpxk6l+IJkiR91//YGPCrCmogU=" crossorigin="anonymous" />

    {{-- Extra css --}}
    @yield('css')
</head>
@php list($ctrl, $action) = explode('@', Route::currentRouteAction()) @endphp
<body class="frontend {{ Request::segment(1) }} {{ str_replace('.', '-', Route::currentRouteName()) }} {{ $action }} @yield('body_class') @auth logged @endauth">

    <main>

        <div id="wrapper-navbar">

            @auth
                <nav class="navbar navbar-expand-md navbar-light bg-dark navbar-second">
                    {{ __('Hola, :name', ['name' => auth()->user()->email]) }}
                    <ul class="navbar-nav ml-sm-auto">
                        <li>
                            <a class="mr-3" href="{{ route('backend.dashboard') }}">
                                {{ __('Mi cuenta') }}
                            </a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Salir') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
            @endauth

            <nav id="navbar-main" class="navbar navbar-light">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="logo logo-color" src="{{ url('svg/logos/logo-commonlandsnet.svg') }}" alt="{{ config('app.name') }}" width="250" height="">
                    <img class="logo logo-bn" src="{{ url('svg/logos/logo-commonlandsnet-bn.svg') }}" alt="{{ config('app.name') }}" width="250" height="">
                    <img class="logo logo-color logo-mini" src="{{ url('svg/logos/logo-commonlandsnet-mini.svg') }}" alt="{{ config('app.name') }}" width="75" height="84">
                    <img class="logo logo-bn logo-mini" src="{{ url('svg/logos/logo-commonlandsnet-mini-bn.svg') }}" alt="{{ config('app.name') }}" width="75" height="84">
                </a>

                @section('navbar')
                    <div class="ml-auto">
                        <ul class="list-inline my-2">
                            @guest
                                <li class="list-inline-item mx-1">
                                    <a href="{{ route('login') }}" class="help-btn">
                                        <img src="{{ url('svg/icons/user.svg') }}" alt="" width="42" height="50">
                                        <span class="help-msg">{{ __('Registro/ Entrar') }}</span>
                                    </a>
                                </li>
                            @endguest
                            <li class="list-inline-item mx-1">
                                <div class="dropdown lang-switcher">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 19.26 26.25"><defs><style>.cls-1,.cls-3{fill:none;}.cls-2{clip-path:url(#clip-path);}.cls-3{stroke:#3c3c3b;stroke-linecap:round;stroke-miterlimit:10;stroke-width:2px;}.cls-4{font-size:8px;fill:#3c3c3b;font-family:Montserrat-Regular, Montserrat;}</style><clipPath id="clip-path"><rect class="cls-1" width="19.26" height="26.6"/></clipPath></defs><title>{{ locale(true) }}</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g class="cls-2"><path class="cls-3" d="M18.25,13.25l-1.51.44a9.37,9.37,0,0,1-2.8.46,8.8,8.8,0,0,1-2.8-.46l-3-1a8.72,8.72,0,0,0-5.61,0L1,13.18V2l1.51-.51a8.72,8.72,0,0,1,5.61,0l3,1a8.8,8.8,0,0,0,2.8.46,9.36,9.36,0,0,0,2.8-.46L18.26,2v11.2ZM1,13.18V23.9"/><text class="cls-4" transform="translate(4.76 24.25)">{{ locale(true) }}</text></g></g></g></svg>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownLanguage">
                                        @foreach (locales(true) as $lang => $text)
                                            @if ($lang != App::getLocale())
                                                <a href="{{ route('lang.switch', $lang) }}" class="dropdown-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 19.26 26.25"><defs><style>.cls-1,.cls-3{fill:none;}.cls-2{clip-path:url(#clip-path);}.cls-3{stroke:#3c3c3b;stroke-linecap:round;stroke-miterlimit:10;stroke-width:2px;}.cls-4{font-size:8px;fill:#3c3c3b;font-family:Montserrat-Regular, Montserrat;}</style><clipPath id="clip-path"><rect class="cls-1" width="19.26" height="26.6"/></clipPath></defs><title>{{ $text }}</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g class="cls-2"><path class="cls-3" d="M18.25,13.25l-1.51.44a9.37,9.37,0,0,1-2.8.46,8.8,8.8,0,0,1-2.8-.46l-3-1a8.72,8.72,0,0,0-5.61,0L1,13.18V2l1.51-.51a8.72,8.72,0,0,1,5.61,0l3,1a8.8,8.8,0,0,0,2.8.46,9.36,9.36,0,0,0,2.8-.46L18.26,2v11.2ZM1,13.18V23.9"/><text class="cls-4" transform="translate(4.76 24.25)">{{ $text }}</text></g></g></g></svg>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </div>

                    <button class="navbar-toggler help-btn" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                        <span class="help-msg">{{ __('Menú') }}</span>
                    </button>

                    <div class="collapse navbar-collapse float-right" id="navbarMenu">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <a class="navbar-brand" href="{{ url('/') }}">
                                        <img class="logo" src="{{ url('svg/logos/logo-commonlandsnet-bn.svg') }}" alt="{{ config('app.name') }}" width="250" height="">
                                        <img class="logo logo-mini" src="{{ url('svg/logos/logo-commonlandsnet-mini-bn.svg') }}" alt="{{ config('app.name') }}" width="75" height="84">
                                    </a>
                                </div>
                                <div class="col-10 offset-1 col-lg-9 offset-lg-3 my-5 mt-lg-0 pl-0 border-0">
                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('/') }}">{{ __('Inicio') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('about') }}">{{ __('Sobre Common Lands Network') }}</a>
                                        </li>
                                        @guest
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                                            </li>
                                        @endguest
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" href="#">{{ __('Usuarios/as') }}</a>
                                        </li> --}}
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" href="#">{{ __('Participa') }}</a>
                                        </li> --}}
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('news.index') }}">{{ __('Noticias') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('event.index') }}">{{ __('Eventos') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('demo.index') }}">{{ __('Casos demostrativos') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('media.index') }}">{{ __('Mediateca') }}</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" href="#">{{ __('Preguntas frecuentes FAQ') }}</a>
                                        </li> --}}
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('contact') }}">{{ __('Contacto') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @show
            </nav>

        </div>

        @yield('content')
    </main>

    <footer>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg pr-xl-5 mr-xl-5">
                    <div class="row">
                        <div class="col-12 footer-text">
                            <p>
                                {!! __(':%1 COMMON LANDS NETWORK :%2 es una red participativa, abierta a personas, comunidades y organizaciones que apoyan los comunales y los Territorios de Vida en Europa, Oriente Medio y Norte de África.', ['%1' => '<strong>', '%2' => '</strong>']) !!}
                            </p>
                        </div>
                        <div class="col-12 col-lg-6 offset-lg-1 d-none d-lg-block1">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <ul class="list-unstyled">
                                        <li>
                                            <a href="#">{{ __('Miembros') }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('contact') }}">{{ __('Contacto') }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <ul class="list-unstyled">
                                        <li>
                                            <a href="#">{{ __('Términos') }}</a>
                                        </li>
                                        <li>
                                            <a href="#">{{ __('Preguntas') }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('register') }}">{{ __('Registro') }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <ul class="list-unstyled">
                                        <li>
                                            <a href="{{ route('lang.switch', 'en') }}">{{ __('Ingles') }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('lang.switch', 'es') }}">{{ __('Español') }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('lang.switch', 'fr') }}">{{ __('Francés') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-auto mb-4 d-none d-lg-block">
                    <div class="row align-items-end">
                        <div class="col-12 col-lg-auto p-4 pr-5">
                            <a href="http://www.icomunales.org/" target="_blank" title="Iniciativa Comunales" class="d-block">
                                <img src="{{ asset('images/logos/logo-INICIATIVA-COMUNALES.png') }}" alt="Iniciativa Comunales" class="img-fluid" width="172">
                            </a>
                        </div>
                        <div class="col-12 col-lg-auto p-4 pl-5 border-left border-white">
                            <a href="https://trashumanciaynaturaleza.org/" target="_blank" title="Asociación Trashumancia y Naturaleza" class="d-block">
                                <img src="{{ asset('svg/logos/logo-trashumancia.svg') }}" alt="Asociación Trashumancia y Naturaleza" class="img-fluid" width="188">
                            </a>
                        </div>
                        <div class="col-12 col-lg-auto p-4">
                            <a href="https://www.landcoalition.org/" target="_blank" title="International Land Coalition" class="d-block">
                                <img src="{{ asset('svg/logos/logo-international-land-coalition.svg') }}" alt="International Land Coalition" class="img-fluid" width="107">
                            </a>
                        </div>
                        <div class="col-12 col-lg-auto p-4">
                            @switch(locale(true))
                                @case('ES')
                                    <a href="https://www.iccaconsortium.org/index.php/es/" target="_blank" title="Consorcio TICCA" class="d-block">
                                        <img src="{{ asset('images/logos/logo-Consorcio-TICCA_ES.png') }}" alt="Consorcio TICCA" class="img-fluid" width="117">
                                    </a>
                                    @break
                                @case('EN')
                                    <a href="https://www.iccaconsortium.org/" target="_blank" title="ICCA Consortium" class="d-block">
                                        <img src="{{ asset('images/logos/logo-ICCA-Consortium_EN.png') }}" alt="ICCA Consortium" class="img-fluid" width="117">
                                    </a>
                                    @break
                                @case('FR')
                                    <a href="https://www.iccaconsortium.org/index.php/fr/" target="_blank" title="Consortium APAC" class="d-block">
                                        <img src="{{ asset('images/logos/Consortium-APAC_FR.png') }}" alt="Consortium APAC" class="img-fluid" width="117">
                                    </a>
                                    @break
                                @default

                            @endswitch
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-12">
                    <strong>© {{ date('Y') }} - {{ config('app.name', 'Laravel') }}.</strong> &nbsp;&nbsp;
                    <a href="{{ route('legal_notice') }}">{{ __('Aviso legal') }}</a> -
                    <a href="{{ route('cookies_policy') }}">{{ __('Política de cookies') }}</a> -
                    <a href="{{ route('privacy_policy') }}">{{ __('Política de privacidad general') }}</a> -
                    <a href="{{ route('terms') }}">{{ __('Términos y condiciones de uso') }}</a>
                </div>
            </div>
        </div>
    </footer>

    @include('partials.footer')

    <script src="{{ url('js/functions.js') }}?{{ config('commonlandsnet.version') }}"></script>

    {{-- Extra js --}}
    @yield('js')
</body>
</html>
