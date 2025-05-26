@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-3">
            <h1>{{ __('Recuperar contraseña') }}</h1>
        </div>
        <div class="col-12 col-sm-11 offset-sm-1 col-lg-9 offset-lg-0">

            @include('partials.notify')

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group row">
                    <div class="col-12">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('Introduce tu mail') }}*" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <input type="image" class="btn btn-xl mt-4" title="{{ __('Recuperar contraseña') }}" src="{{ url('svg/icons/send.svg') }}" value="{{ __('Enviar') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
