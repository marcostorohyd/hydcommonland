@extends('backend.layouts.app')

@section('title', __('Eventos'))

@section('content')
{!! Form::model($event, ['route' => ['backend.event.update', $event->id], 'method' => 'PUT', '', 'id' => 'form']) !!}
    @include('backend.event.fields')

    <div class="row">
        <div class="col-12">
            <button class="btn btn-dark btn-lg" type="submit">{{ __('Guardar/Actualizar') }}</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection
