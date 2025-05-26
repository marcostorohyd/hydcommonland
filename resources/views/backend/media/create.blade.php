@extends('backend.layouts.app')

@section('content')
{!! Form::open(['route' => 'backend.media.store', 'method' => 'POST', 'id' => 'form']) !!}

    @if (auth()->user()->isAdmin())
        @section('title', __('Mediateca'))
    @else
        @section('title', __('Envíe su contenido audio visual'))
        <div class="row">
            <div class="col-12">
                <p class="mb-5">
                    {{ __('Si tiene contenido audiovisual (vídeos, fotografías, presentaciones en power points, documentos de word o audios) que crea que son importantes y le gustaría compartir con nuestra audiencia, utilice nuestro formulario de envío en línea. Si su caso está aprobado para aparecer en nuestra sección de mediateca, estará disponible en un plazo de 5 días hábiles. ¡Gracias!') }}
                </p>
            </div>
        </div>
    @endif

    @include('backend.media.fields')

    <div class="row">
        <div class="col-12">
            <button class="btn btn-dark btn-lg" type="submit">{{ __('Crear') }}</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection
