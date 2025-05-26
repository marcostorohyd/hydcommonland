@extends('layouts.app')

@section('content')
<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-3">
                <h1>{{ __('Cambiar contraseña') }}</h1>
            </div>
            <div class="col-12 col-sm-11 offset-sm-1 col-lg-9 offset-lg-0">

                @include('partials.notify')

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group row">
                        <div class="col-12">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" placeholder="{{ __('Correo electrónico') }}*" required autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12 input-group">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Contraseña') }}*" required>
                            <div class="input-group-append toggle-password">
                                <span class="input-group-text"><img src="{{ asset('svg/icons/eye.svg') }}" width="30" height="10"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12 input-group">
                            <input id="password_confirmation" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="{{ __('Confirmar contraseña') }}*" required>
                            <div class="input-group-append toggle-password">
                                <span class="input-group-text"><img src="{{ asset('svg/icons/eye.svg') }}" width="30" height="10"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <input type="image" class="btn btn-xl mt-4" title="{{ __('Cambiar contraseña') }}" src="{{ url('svg/icons/send.svg') }}" value="{{ __('Enviar') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
