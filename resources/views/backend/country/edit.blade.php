@extends('backend.layouts.app')

@section('title', __('Países'))

@section('content')
{!! Form::model($country, ['route' => ['backend.country.update', $country->id], 'method' => 'PUT']) !!}
    <h2>{{ __('Editar país') }}</h2>
    @include('backend.country.fields')

    <div class="row">
        <div class="col-12">
            <button class="btn btn-dark btn-lg" type="submit">{{ __('Guardar/Actualizar') }}</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection
