@extends('backend.layouts.app')

@section('title', __('Países'))

@section('content')
{!! Form::open(['route' => 'backend.country.store', 'method' => 'POST']) !!}
    <h2>{{ __('Nuevo país') }}</h2>
    @include('backend.country.fields')

    <div class="row">
        <div class="col-12">
            <button class="btn btn-dark btn-lg" type="submit">{{ __('Crear') }}</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection
