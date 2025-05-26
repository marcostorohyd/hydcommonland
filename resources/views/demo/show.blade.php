@extends('layouts.app')

@section('body_class', 'two-columns-invert')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm order-xl-2 overflow">
            <div class="row">
                <div class="col-12 pb-1">
                    <div class="text-uppercase mb-2">{{ $demo->date->format('d M Y') }}</div>
                    <img class="img-fluid d-xl-none" src="{{ $demo->imageUrl() }}" alt="">
                    <h1>{{ $demo->name }}</h1>
                    <div class="row mx-0">
                        <div class="col-12 col-xl-8">
                            <dl class="row">
                                <dt class="col-4 pl-0">{{ __('País') }}</dt>
                                <dd class="col-8">{{ $demo->country->name }}</dd>
                                @if (! empty($demo->address))
                                    <dt class="col-4 pl-0">{{ __('Lugar') }}</dt>
                                    <dd class="col-8">{{ $demo->address }}</dd>
                                @endif
                                @if (! empty($demo->link))
                                    <dt class="col-4 pl-0">{{ __('Enlace') }}</dt>
                                    <dd class="col-8"><a href="{{ $demo->link }}" target="_blank">{{ $demo->link }}</a></dd>
                                @endif
                                @if (! empty($demo->link2))
                                    <dt class="col-4 pl-0">{{ __('Enlace') }}</dt>
                                    <dd class="col-8"><a href="{{ $demo->link2 }}" target="_blank">{{ $demo->link2 }}</a></dd>
                                @endif
                                @if (! empty($demo->link3))
                                    <dt class="col-4 pl-0">{{ __('Enlace') }}</dt>
                                    <dd class="col-8"><a href="{{ $demo->link3 }}" target="_blank">{{ $demo->link3 }}</a></dd>
                                @endif
                                @if (! empty($demo->link4))
                                    <dt class="col-4 pl-0">{{ __('Enlace') }}</dt>
                                    <dd class="col-8"><a href="{{ $demo->link4 }}" target="_blank">{{ $demo->link4 }}</a></dd>
                                @endif
                                @if (! empty($demo->link5))
                                    <dt class="col-4 pl-0">{{ __('Enlace') }}</dt>
                                    <dd class="col-8"><a href="{{ $demo->link5 }}" target="_blank">{{ $demo->link5 }}</a></dd>
                                @endif
                                @if (! empty($demo->email))
                                    <dt class="col-4 pl-0">{{ __('Contacto') }}</dt>
                                    <dd class="col-8"><a href="mailto:{{ $demo->email }}" target="_blank">{{ $demo->email }}</a></dd>
                                @endif
                            </dl>
                        </div>
                    </div>
                    <div class="row mx-0">
                        <div class="col-12 pl-0">
                            <ul class="list-values">
                                @foreach ($demo->values as $item)
                                    <li><img src="{{ $item->imageMiniUrl() }}" alt="{{ $item->name }}" title="{{ $item->name }}"></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-none d-xl-flex">
                <div class="col-12">
                    <div class="font-lg pr-2">{!! $demo->description !!}</div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-5 mb-xl-0 pt-xl-2">
            <img class="img-fluid d-none d-xl-inline img-fit navigation-float-pre" src="{{ $demo->imageUrl() }}" alt="">

            <div class="row d-xl-none">
                <div class="col-12 mb-5 mt-3 font-lg">
                    {!! $demo->description !!}
                </div>
            </div>

            @if (! empty($paginate))
                <div id="paginate-image" class="navigation navigation-float">
                    @if (! empty($paginate['prev']))
                        <input type="image" class="btn btn-xl prev" title="{{ __('Anterior') }}" src="{{ url('svg/icons/prev.svg') }}" value="{{ __('Anterior') }}">
                    @endif
                    @if (! empty($paginate['next']))
                        <input type="image" class="btn btn-xl next float-right" title="{{ __('Siguiente') }}" src="{{ url('svg/icons/next.svg') }}" value="{{ __('Siguiente') }}">
                    @endif
                </div>
            @endif
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
            $('#paginate-image .prev').click(function (e) {
                window.location.href = '{{ route('demo.show', $paginate['prev']) }}?current={{ $current - 1 }}';
            });
        @endif
        @if (! empty($paginate['next']))
            $('#paginate-image .next').click(function (e) {
                window.location.href = '{{ route('demo.show', $paginate['next']) }}?current={{ $current + 1 }}';
            });
        @endif

        $('[type="image"].close').click(function (e) {
            window.location.href = '{{ route('demo.index') }}?close=true';
        });
    });
</script>
@endsection
