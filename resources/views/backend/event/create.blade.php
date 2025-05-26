@extends('backend.layouts.app')

@section('content')
{!! Form::open(['route' => 'backend.event.store', 'method' => 'POST', 'id' => 'form']) !!}

    @if (auth()->user()->isAdmin())
        @section('title', __('Eventos'))
    @else
        @section('title', __('Envíe un evento'))
        <div class="row">
            <div class="col-12">
                <p class="mb-5">
                    {{ __('Si estás organizando un evento que te gustaría compartir en la plataforma, utiliza nuestro formulario. Normalmente, el evento estará disponible en el calendario en unos 5 días. ¡Gracias!') }}
                </p>
            </div>
        </div>
    @endif

    @include('backend.event.fields')

    <div class="row">
        <div class="col-12">
            <button class="btn btn-dark btn-lg" type="submit">{{ __('Crear') }}</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection
