@extends('backend.layouts.app')

@section('title', __('Mediateca'))

@section('content')
{!! Form::model($media, ['route' => ['backend.media.update', $media->id], 'method' => 'PUT', 'id' => 'form']) !!}
    @include('backend.media.fields')

    <div class="row">
        <div class="col-12">
            <button class="btn btn-dark btn-lg" type="submit">{{ __('Guardar/Actualizar') }}</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection
