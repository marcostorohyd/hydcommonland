<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | {{ config('app.name') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" integrity="sha256-MeSf8Rmg3b5qLFlijnpxk6l+IJkiR91//YGPCrCmogU=" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.4/b-html5-1.5.4/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" integrity="sha256-yMjaV542P+q1RnH6XByCPDfUFhmOafWbeLPmqKh11zo=" crossorigin="anonymous" />
    <link href="{{ asset('css/backend.css') }}?{{ config('commonlandsnet.version') }}" rel="stylesheet">

    {{-- Extra css --}}
    @yield('css')
</head>
@php list($ctrl, $action) = explode('@', Route::currentRouteAction()) @endphp
<body class="backend {{ Request::segment(1) }} {{ str_replace('.', '-', Route::currentRouteName()) }} {{ $action }} @yield('body_class')">

    <main>

        <div id="wrapper-navbar">

            @include('backend.partials.navbar')

            <nav id="navbar-main" class="navbar navbar-light pb-2 pb-sm-4">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="logo" src="{{ url('svg/logos/logo-commonlandsnet-bn.svg') }}" alt="{{ config('app.name') }}" width="250" height="">
                    <img class="logo logo-mini" src="{{ url('svg/logos/logo-commonlandsnet-mini-bn.svg') }}" alt="{{ config('app.name') }}" width="75" height="84">
                </a>

                <div class="ml-auto">
                    <ul class="list-inline my-2">
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

                <button class="navbar-toggler help-btn d-lg-none" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                    <span class="help-msg">{{ __('Menú') }}</span>
                </button>

                <div class="collapse navbar-collapse float-right" id="navbarMenu">
                    <ul class="navbar-nav pl-0 pl-md-5 mt-5">
                        @include('backend.partials.sidebar')
                    </ul>
                </div>
            </nav>

            @include('backend.partials.navbar')

        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-3 d-none d-lg-block">
                    <ul class="sidebar list-unstyled" id="sidebar">
                        @include('backend.partials.sidebar')
                    </ul>
                </div>
                <div class="col-12 col-sm-11 mx-auto col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <h1>@yield('title', 'Dashboard')<div id="paginate-wrapper"></div></h1>
                        </div>
                        <div class="col-12">
                            {{ Breadcrumbs::render() }}
                        </div>
                        <div id="error-wrapper" class="col-12">
                            @include('partials.notify')
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <p><strong>© {{ date('Y') }} - {{ config('app.name', 'Laravel') }}.</strong></p>
                </div>
            </div>
        </div>
    </footer>

    @include('partials.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha256-5YmaxAwMjIpMrVlK84Y/+NjCpKnFYa8bWWBbUHSBGfU=" crossorigin="anonymous"></script>

    <script src="{{ asset('js/functions.js') }}?{{ config('commonlandsnet.version') }}"></script>

    <script>
        $(function () {
            $('.date').datetimepicker({
                format: 'L',
                extraFormats: ['YYYY-MM-DD']
            });
        });
    </script>

    {{-- Extra js --}}
    @yield('js')
</body>
</html>
