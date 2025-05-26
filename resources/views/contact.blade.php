@extends('layouts.app')

@section('title', __('Contacto'))

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-3">
            <h1>{{ __('Contacto') }}</h1>
        </div>
        <div class="col-12 col-lg font-lg">
            <div class="row mb-5">
                <div class="col-12">
                    <h3>{{ __('Contacto general') }}</h3>
                    <div>
                        <p>
                            {{ $config['contact_name'] }}
                            <br><a href="mailto:{{ $config['contact_email'] }}">{{ $config['contact_email'] }}</a>
                            <br><a href="tel:{{ $config['contact_phone'] }}">{{ $config['contact_phone'] }}</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h3>{{ __('Contacto por países') }}</h3>
                    <div class="list-wrapper offset-sm-1 offset-lg-0">
                        <ul class="list list-border list-grid">
                            @foreach ($countries as $country)
                                @if ($country->contact_id)
                                    <li><a href="{{ route('directory.show', $country->contact_id) }}" title="{{ __('Ver detalles') }}">{{ $country->name }}</a></li>
                                @else
                                    <li><span class="link">{{ $country->name }}</span></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
