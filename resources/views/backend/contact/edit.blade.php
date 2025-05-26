@extends('backend.layouts.app')

@section('title', __('Contacto'))

@section('content')
{!! Form::open(['route' => ['backend.contact.update'], 'method' => 'PUT']) !!}
    <h2>{{ __('Contacto general') }}</h2>
    <div class="row">
        <div class="col-12 col-md-6 form-group">
            {!! Form::text('contact_name', old('contact_name', $config['contact_name']), ['class' => 'form-control' . ($errors->has('contact_name') ? ' is-invalid' : ''), 'placeholder' => __('Nombre') . '*', 'required']) !!}
        </div>
        <div class="col-12 col-md-6 form-group">
            {!! Form::text('contact_phone', old('contact_phone', $config['contact_phone']), ['class' => 'form-control' . ($errors->has('contact_phone') ? ' is-invalid' : ''), 'placeholder' => __('Teléfono') . '*', 'required']) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::email('contact_email', old('contact_email', $config['contact_email']), ['class' => 'form-control' . ($errors->has('contact_email') ? ' is-invalid' : ''), 'placeholder' => __('Email') . '*', 'required']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <button class="btn btn-dark btn-lg" type="submit">{{ __('Guardar/Actualizar') }}</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection
