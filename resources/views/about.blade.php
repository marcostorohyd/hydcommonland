@extends('layouts.app')

@section('title', __('Sobre Common Lands Network'))

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-3">
            <h1>{{ __('Sobre Common Lands Network') }}</h1>
        </div>
        <div class="col-12 col-lg font-lg">
            <div class="row">
                <div class="col-12">
                    {!! $about !!}
                </div>
                @if ($leaflet_link)
                    <div class="col-12 mt-5">
                        @if ($leaflet_image)
                            <a href="{{ $leaflet_link }}" title="{{ __('Descargar folleto') }}">
                                <img class="img-fluid mb-4" id="image" src="{{ \App\Config::aboutLeafletImageUrl($leaflet_image) }}" alt="">
                            </a>
                        @else
                            <a href="{{ $leaflet_link }}" title="{{ __('Descargar folleto') }}">{{ __('Descargar folleto') }}</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
