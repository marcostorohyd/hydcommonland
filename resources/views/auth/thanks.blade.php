@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-3">
            <h1>{{ __('Participa') }}</h1>
        </div>
        <div class="col-12 col-sm-11 offset-sm-1 col-lg-9 offset-lg-0">
            <p class="mb-5">{!! __('¡Gracias por participar! Tus datos han sido enviados correctamente. El administrador revisará tus datos para poderte dar de alta. En breve recibirás un mail de confirmación y podrás empezar a usar la plataforma.') !!}</p>
        </div>
    </div>
</div>
@endsection
