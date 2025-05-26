@extends('backend.layouts.app')

@section('title', __('Casos demostrativos'))

@section('content')
{!! Form::model($demo, ['route' => ['backend.demo.update', $demo->id], 'method' => 'PUT', 'id' => 'form']) !!}
    @include('backend.demo.fields')

    <div class="row">
        <div class="col-12">
            <button class="btn btn-dark btn-lg" type="submit">{{ __('Guardar/Actualizar') }}</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection
