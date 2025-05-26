@extends('backend.layouts.app')

@section('title', __('Usuarios/as'))

@section('content')
{!! Form::open(['route' => 'backend.directory.store', 'method' => 'POST', 'id' => 'form']) !!}
    @include('backend.directory.fields')

    <div class="row">
        <div class="col-12">
            <button class="btn btn-dark btn-lg" type="submit">{{ __('Crear') }}</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection
