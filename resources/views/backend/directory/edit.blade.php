@extends('backend.layouts.app')

@section('title', __('Usuarios/as'))

@section('content')
{!! Form::model($directory, ['route' => ['backend.directory.update', $directory->id], 'method' => 'PUT', 'id' => 'form']) !!}
    @include('backend.directory.fields')

    <div class="row">
        <div class="col-12">
            <button class="btn btn-dark btn-lg" type="submit">{{ __('Guardar/Actualizar') }}</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection
