@extends('layouts.app')

@section('body_class', 'two-columns-invert')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-xl-7 col-xl order-xl-2 overflow">
            <div class="row">
                <div class="col-12 pb-1">
                    <div class="text-uppercase mb-2">{{ $event->start->format('d M Y') }} {{ ! empty($event->end) ? ' - ' . $event->end->format('d M Y') : '' }}</div>
                    <h1>{{ $event->name }}</h1>
                    <div class="row mx-0">
                        <div class="col-12 col-xl-8">
                            <dl class="row">
                                <dt class="col-4 pl-0">{{ __('Tipo') }}</dt>
                                <dd class="col-8">{{ $event->type->name }}</dd>
                                @if (! empty($event->venue_name))
                                    <dt class="col-4 pl-0">{{ __('Nombre del lugar') }}</dt>
                                    <dd class="col-8">{{ $event->venue_name }}</dd>
                                @endif
                                @if (! empty($event->venue_address))
                                    <dt class="col-4 pl-0">{{ __('Dirección del lugar') }}</dt>
                                    <dd class="col-8">{{ $event->venue_address }}</dd>
                                @endif
                                @if (! empty($event->country_id))
                                    <dt class="col-4 pl-0">{{ __('País') }}</dt>
                                    <dd class="col-8">{{ $event->country->name }}</dd>
                                @endif
                                @if (! empty($event->assistance))
                                    <dt class="col-4 pl-0">{{ __('Asistencia') }}</dt>
                                    <dd class="col-8">{{ $event->assistance->name }}</dd>
                                @endif
                                @if (! empty($event->language))
                                    <dt class="col-4 pl-0">{{ __('Idioma') }}</dt>
                                    <dd class="col-8">{{ $event->language }}</dd>
                                @endif
                                <dt class="col-4 pl-0">{{ __('Contacto') }}</dt>
                                <dd class="col-8"><a href="mailto:{{ $event->email }}" target="_blank">{{ $event->email }}</a></dd>
                                @if (! empty($event->register_url))
                                    <dt class="col-4 pl-0">{{ __('Enlace') }}</dt>
                                    <dd class="col-8"><a href="{{ $event->register_url }}" target="_blank">{{ $event->register_url }}</a></dd>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-none d-xl-flex">
                <div class="col-12">
                    <div class="font-lg pr-2">{!! $event->description !!}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-5 col-xl-4 mb-5 mb-xl-0 pt-xl-2">
            <img class="img-fluid img-fit navigation-float-pre" src="{{ $event->imageUrl() }}" alt="">

            <div class="row d-xl-none">
                <div class="col-12 mb-5 mt-3 font-lg">
                    {!! $event->description !!}
                </div>
            </div>

            @if (! empty($paginate))
                <div class="navigation navigation-float">
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
            $('[type="image"].prev').click(function (e) {
                window.location.href = '{{ route('event.show', $paginate['prev']) }}';
            });
        @endif
        @if (! empty($paginate['next']))
            $('[type="image"].next').click(function (e) {
                window.location.href = '{{ route('event.show', $paginate['next']) }}';
            });
        @endif

        $('[type="image"].close').click(function (e) {
            window.location.href = '{{ route('event.index') }}?close=true';
        });
    });
</script>
@endsection
