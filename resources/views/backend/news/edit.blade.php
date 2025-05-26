@extends('backend.layouts.app')

@section('title', __('Noticias'))

@section('content')
{!! Form::model($news, ['route' => ['backend.news.update', $news->id], 'method' => 'PUT', 'id' => 'form']) !!}
    @include('backend.news.fields')

    <div class="row">
        <div class="col-12">
            <button class="btn btn-dark btn-lg" type="submit">{{ __('Guardar/Actualizar') }}</button>
        </div>
    </div>
{!! Form::close() !!}
@endsection
