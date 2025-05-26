@extends('backend.layouts.app')

@section('content')
{!! Form::open(['route' => 'backend.news.store', 'method' => 'POST', 'id' => 'form']) !!}

    @if (auth()->user()->isAdmin())
        @section('title', __('Noticias'))
    @else
        @section('title', __('Envíe una noticia'))
        <div class="row">
            <div class="col-12">
                <p class="mb-5">
                    {{ __('Si quieres compartir una noticia en la plataforma, utiliza nuestro formulario. Normalmente, la noticia será publicada en unos 5 días. ¡Gracias!') }}
                </p>
            </div>
        </div>
    @endif

    @include('backend.news.fields')

    <div class="row">
        <div class="col-12">
            <button class="btn btn-dark btn-lg" type="submit">{{ __('Crear') }}</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection
