@extends('backend.layouts.app')

@section('content')
{!! Form::open(['route' => 'backend.demo.store', 'method' => 'POST', 'id' => 'form']) !!}

    @if (auth()->user()->isAdmin())
        @section('title', __('Casos demostrativos'))
    @else
        @section('title', __('Envíe un caso demostrativo'))
        <div class="row">
            <div class="col-12">
                <p class="mb-5">
                    {{ __('Si quieres compartir un caso demostrativo que contribuye a alguno o varios de los 10 valores, utiliza nuestro formulario. Normalmente, el caso demostrativo será publicado en unos 5 días. ¡Gracias!') }}
                </p>
            </div>
        </div>
    @endif

    @include('backend.demo.fields')

    <div class="row">
        <div class="col-12">
            <button class="btn btn-dark btn-lg" type="submit">{{ __('Crear') }}</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection
