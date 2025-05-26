@extends('layouts.app')

@section('body_class', 'two-columns-invert')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm order-xl-2 overflow">
            <div class="row">
                <div class="col-12 pb-1">
                    <div class="text-uppercase mb-2">{{ $news->date->format('d M Y') }}</div>
                    <h1>{{ $news->name }}</h1>
                    <div class="row mx-0">
                        <div class="col-12 col-xl-8">
                            <dl class="row">
                                @if (! empty($news->country_id))
                                    <dt class="col-4 pl-0">{{ __('País') }}</dt>
                                    <dd class="col-8">{{ $news->country->name }}</dd>
                                @endif
                                <dt class="col-4 pl-0">{{ __('Contacto') }}</dt>
                                <dd class="col-8"><a href="mailto:{{ $news->email }}" target="_blank">{{ $news->email }}</a></dd>
                                @if (! empty($news->link))
                                    <dt class="col-4 pl-0">{{ __('Enlace') }}</dt>
                                    <dd class="col-8"><a href="{{ $news->link }}" target="_blank">{{ $news->link }}</a></dd>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-none d-xl-flex">
                <div class="col-12">
                    <div class="font-lg pr-2">{!! $news->description !!}</div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-5 mb-xl-0 pt-xl-2">
            <img class="img-fluid img-fit navigation-float-pre" src="{{ $news->imageUrl() }}" alt="">

            <div class="row d-xl-none">
                <div class="col-12 mb-5 mt-3 font-lg">
                    {!! $news->description !!}
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
                window.location.href = '{{ route('news.show', $paginate['prev']) }}';
            });
        @endif
        @if (! empty($paginate['next']))
            $('[type="image"].next').click(function (e) {
                window.location.href = '{{ route('news.show', $paginate['next']) }}';
            });
        @endif

        $('[type="image"].close').click(function (e) {
            window.location.href = '{{ route('news.index') }}?close=true';
        });
    });
</script>
@endsection
