@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-3">
            <h1>{{ __('Iniciar sesión') }}</h1>
        </div>
        <div class="col-12 col-sm-11 offset-sm-1 col-lg-9 offset-lg-0">

            @include('partials.notify')

            <div class="row">
                <div class="col-lg-6 mb-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <h6 class="font-weight-bold mt-5 mt-lg-0 mb-4">{{ __('Entrar') }}</h6>

                        <div class="form-group row">
                            <div class="col-12">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('Introduce tu mail:') }}*" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 input-group">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Contraseña:') }}*" required>
                                <div class="input-group-append toggle-password">
                                    <span class="input-group-text"><img src="{{ asset('svg/icons/eye.svg') }}" width="30" height="10"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="custom-control-label" for="remember">
                                        {{ __('Recuérdame') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-12">
                                <input type="image" class="btn btn-xl my-5" title="{{ __('Entrar') }}" src="{{ url('svg/icons/send.svg') }}" value="{{ __('Enviar') }}">
                                <p>
                                    <a href="{{ route('password.request') }}">
                                        {{ __('¿Olvidaste la contraseña?') }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <form method="GET" action="{{ route('register') }}">
                        @csrf

                        <h6 class="font-weight-bold mb-4">{{ __('Registro') }}</h6>

                        <div class="form-group row">
                            <div class="col-12">
                                <div class="form-control-plaintext mb-1">{{ __('¿Te gustaría unirte a la plataforma?') }}</div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-12 mb-5">
                                <div class="form-control-plaintext mb-1">{!! __('Completa el :tag1s formulario de registro :tag2e', ['tag1s' => '<a href="' . route('register') . '">', 'tag2e' => '</a>']) !!}</div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-12">
                                <input type="image" class="btn btn-xl my-5" title="{{ __('Registro') }}" src="{{ url('svg/icons/send.svg') }}" value="{{ __('Nuevo registro') }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
