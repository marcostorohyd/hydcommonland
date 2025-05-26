@extends('layouts.app')

@section('body_class', 'three-columns one-two')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-4 col-xl-3 mb-5 mb-lg-0">
            <h1>{{ $directory->name }}</h1>
            <p class="form-control-plaintext text-uppercase">{{ $directory->entity->name }}</p>
            <p class="form-control-plaintext text-uppercase">{{ $directory->country->name }}</p>
            <p class="form-control-plaintext navigation-float-pre">{{ $directory->sectors->pluck('name')->implode(', ') }}</p>

            @if (! empty($paginate))
                <div class="navigation navigation-float d-none d-lg-block">
                    @if (! empty($paginate['prev']))
                        <input type="image" class="btn btn-xl prev" title="{{ __('Anterior') }}" src="{{ url('svg/icons/prev.svg') }}" value="{{ __('Anterior') }}">
                    @endif
                    @if (! empty($paginate['next']))
                        <input type="image" class="btn btn-xl next" title="{{ __('Siguiente') }}" src="{{ url('svg/icons/next.svg') }}" value="{{ __('Siguiente') }}">
                    @endif
                </div>
            @endif
        </div>
        <div class="col-12 col-lg-8 col-xl mb-5 mb-lg-0">
            <div class="row" id="overflow-max">
                <div class="col-12 col-xl-4 mb-5 mb-xl-0">
                    <div class="row mb-5 mb-lg-4">
                        <div class="col">
                            <h4>{{ __('Contacto') }}</h4>
                            <p class="form-control-plaintext">{{ $directory->fullAddress() }}</p>
                            @if (! empty($directory->phone))
                                <p class="form-control-plaintext"><a href="tel:{{ $directory->phone }}">{{ $directory->phone }}</a></p>
                            @endif
                            <p class="form-control-plaintext"><a href="mailto:{{ $directory->email }}">{{ $directory->email }}</a></p>
                            @if (! empty($directory->web))
                                <p class="form-control-plaintext"><a href="{{ $directory->web }}" target="_blank">{{ $directory->web }}</a></p>
                            @endif
                            @if ($directory->hasSocialAttributes())
                                <ul class="list-inline mt-3 mb-0">
                                    @foreach (\App\Directory::SocialAttributes() as $item)
                                        @if (! empty($directory->{$item}))
                                            <li class="list-inline-item">
                                                <a href="{{ $directory->{$item} }}" target="_blank">
                                                    <i class="icon icon-{{ str_replace('_', '-', $item) }} icon-lg"></i>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    @if (! empty($directory->contact_name) || ! empty($directory->contact_email) || ! empty($directory->contact_phone))
                        <div class="row mb-5 mb-lg-4">
                            <div class="col">
                                <h4>{{ __('Persona de contacto') }}</h4>
                                @if (! empty($directory->contact_name))
                                    <p class="form-control-plaintext">{{ $directory->contact_name }}</p>
                                @endif
                                @if (! empty($directory->contact_email))
                                    <p class="form-control-plaintext"><a href="mailto:{{ $directory->contact_email }}">{{ $directory->contact_email }}</a></p>
                                @endif
                                @if (! empty($directory->contact_phone))
                                    <p class="form-control-plaintext"><a href="tel:{{ $directory->contact_phone }}">{{ $directory->contact_phone }}</a></p>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if (! empty($directory->members) || ! empty($directory->partners) || ! empty($directory->represented) || ($directory->hasSurface() && ! empty($directory->surface)))
                        <div class="row">
                            <div class="col">
                                <h4>{{ __('Info adicional') }}</h4>
                                @if (! empty($directory->partners))
                                    <p class="form-control-plaintext">{{ __('Nº de socios/as' ) }}: {{ $directory->partners }}</p>
                                @endif
                                @if (! empty($directory->members))
                                    <p class="form-control-plaintext">{{ __('Nº de comuneras/os' ) }}: {{ $directory->members }}</p>
                                @endif
                                @if (! empty($directory->represented))
                                    <p class="form-control-plaintext">{{ __('Número de personas representadas' ) }}: {{ $directory->represented }}</p>
                                @endif
                                @if ($directory->hasSurface() && ! empty($directory->surface))
                                    <p class="form-control-plaintext">{{ __('Superficie' ) }}: {{ $directory->surface }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-12 col-xl-8 overflow" data-overflow-max="#overflow-max">
                    @if ($directory->image)
                        <img class="img-fluid mb-4" id="image" src="{{ $directory->imageUrl() }}" alt="">
                    @endif
                    <div class="font-lg pr-2">{!! $directory->description !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="navigation" class="d-none">
    <div class="navigation">
        <input type="image" class="btn btn-lg close" title="{{ __('Cerrar') }}" src="{{ url('svg/icons/close.svg') }}" value="{{ __('Cerrar') }}">
    </div>
</div>

@endsection

@section('js')
<script>
    $(function () {
        $('#navbar-main > *').not('a').css('display', 'none');
        if (! $('#navbar-main > .navigation').length) {
            $('#navbar-main').append($('#navigation').html());
            submitImageHover();
        }

        @if (! empty($paginate['prev']))
            $('[type="image"].prev').click(function (e) {
                window.location.href = '{{ route('directory.show', $paginate['prev']) }}';
            });
        @endif
        @if (! empty($paginate['next']))
            $('[type="image"].next').click(function (e) {
                window.location.href = '{{ route('directory.show', $paginate['next']) }}';
            });
        @endif

        $('[type="image"].close').click(function (e) {
            @if ('contact' == app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName())
                window.location.href = '{{ route('contact') }}';
            @else
                window.location.href = '{{ route('home') }}?close=true';
            @endif
        });
    });
</script>
@endsection
