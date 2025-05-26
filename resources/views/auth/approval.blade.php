@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-3">
            <h1>{{ __('Pendiente de aprobación') }}</h1>
        </div>
        <div class="col-12 col-sm-11 offset-sm-1 col-lg-9 offset-lg-0">
            <p class="mb-5">{!! __('Su registro está pendiente de aprobación.') !!}</p>
        </div>
    </div>
</div>
@endsection
