@extends('layouts.app')

@section('body_class', 'three-columns')

@section('content')

    {!! Form::open(['route' => 'home', 'method' => 'post', 'id' => 'filter']) !!}
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-4 col-xl-3 mb-4">
                    <a href="#" class="title mb-lg-4" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">{{ __('Filtro') }}</a>
                    <div class="row d-none d-lg-flex">
                        <div class="col-12 mb-2">
                            <label for="">{{ __('Entidad') }}</label>
                            {!! Form::select('entity_id[]', $data['entities'], null, ['class' => 'form-control form-control-sm select2 emulate-select-invert' . ($errors->has('entity_id') ? ' is-invalid' : ''), 'id' => 'entities', 'multiple', 'data-emulate' => '#collapseEntities']) !!}
                        </div>
                        <div class="col-12 mb-2">
                            <label for="">{{ __('País') }}</label>
                            {!! Form::select('country_id[]', $data['countries'], null, ['class' => 'form-control form-control-sm select2 emulate-select-invert' . ($errors->has('country_id') ? ' is-invalid' : ''), 'id' => 'countries', 'multiple', 'data-emulate' => '#collapseCountries']) !!}
                        </div>
                        <div class="col-12 mb-2">
                            <label for="">{{ __('Sector') }}</label>
                            {!! Form::select('sector_id[]', $data['sectors'], null, ['class' => 'form-control form-control-sm select2 emulate-select-invert' . ($errors->has('sector_id') ? ' is-invalid' : ''), 'id' => 'sectors', 'multiple', 'data-emulate' => '#collapseSectors']) !!}
                        </div>
                    </div>
                    <div class="row d-lg-none collapse" id="collapseFilters">
                        <div class="col-12">
                            <a href="#" class="label" data-toggle="collapse" data-target="#collapseEntities" aria-expanded="false" aria-controls="collapseEntities">{{ __('Entidad') }}</a>
                            <ul class="list-unstyled collapse emulate-select" id="collapseEntities">
                                @forelse ($data['entities'] as $value => $text)
                                    <li><a href="#" data-value="{{ $value }}" data-select="#entities">{{ $text }}</a></li>
                                @empty
                                    {{ __('No se han encontrado entidades') }}
                                @endforelse
                            </ul>
                        </div>
                        <div class="col-12">
                            <a href="#" class="label" data-toggle="collapse" data-target="#collapseCountries" aria-expanded="false" aria-controls="collapseCountries">{{ __('País') }}</a>
                            <ul class="list-unstyled collapse emulate-select" id="collapseCountries">
                                @forelse ($data['countries'] as $value => $text)
                                    <li><a href="#" data-value="{{ $value }}" data-select="#countries">{{ $text }}</a></li>
                                @empty
                                    {{ __('No se han encontrado países') }}
                                @endforelse
                            </ul>
                        </div>
                        <div class="col-12">
                            <a href="#" class="label" data-toggle="collapse" data-target="#collapseSectors" aria-expanded="false" aria-controls="collapseSectors">{{ __('Sector') }}</a>
                            <ul class="list-unstyled collapse emulate-select" id="collapseSectors">
                                @forelse ($data['sectors'] as $value => $text)
                                    <li><a href="#" data-value="{{ $value }}" data-select="#sectors">{{ $text }}</a></li>
                                @empty
                                    <li>{{ __('No se han encontrado sectores') }}</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 col-xl-9">
                    <div class="row subsection">
                        <div class="col-sm-6 col-lg-12">
                            <ul class="list-inline font-weight-bold mb-4">
                                <li class="list-inline-item">
                                    {{ __('Modo de visualización') }}:
                                </li>
                                <li class="list-inline-item">
                                    <a id="btn-map" href="#" title="{{ __('Mapa') }}">{{ __('Mapa') }}</a>
                                </li>
                                <li class="list-inline-item">
                                    <a id="btn-list" href="#" title="{{ __('A-Z') }}">{{ __('A-Z') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="wrapper" style="height: 100%;">
                        @include('directory.map')
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

    <div class="container-fluid mt-5 py-4 bg-yellow">
        @include('page._partials.home-lopd.' . strtolower(locale(true)))
    </div>

@endsection

@section('js')
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key={{ config('commonlandsnet.google_key_map') }}"></script>
{{-- <script src="https://cdn.rawgit.com/googlemaps/js-marker-clusterer/gh-pages/src/markerclusterer.js"></script> --}}
<script src="{{ url('/js/maps.js?' . date('his')) }}"></script>
<script>
    var url = '{{ route('directory.map') }}';
    function filter(params) {
        $.post(url, params, function (res) {
            checkMap();
            $('#wrapper').html(res);
        });
    }

    function checkMap() {
        $('body').toggleClass('map', '{{ route('directory.map') }}' == url);
    }

    $(function () {
        checkMap();

        $('#filter select').change(function (e) {
            filter($(this).closest('form').serialize());
        });

        $('#btn-list').click(function (e) {
            e.preventDefault();
            url = '{{ route('directory.list') }}';
            filter($(this).closest('form').serialize());
            return false;

        });

        $('#btn-map').click(function (e) {
            e.preventDefault();
            url = '{{ route('directory.map') }}';
            filter($(this).closest('form').serialize());
            return false;
        });

        setInterval(function () {
            $('#wrapper .page-link').unbind();
            $('#wrapper .page-link').click(function (e) {
                e.preventDefault();
                e.stopPropagation();

                var page = getUrlParameter('page', $(this).attr('href'));
                filter($('#filter').closest('form').serialize() + '&page=' + page);

                return false;
            });
        }, 500);

        $('.emulate-select a').click(function (e) {
            e.preventDefault();

            var select = $(this).data('select');
            var value = $(this).data('value');

            $(this).toggleClass('selected');

            $(select + ' option[value="' + value + '"]').prop('selected', $(this).hasClass('selected')).change();
        });

        $('.emulate-select-invert').change(function (e) {
            var select = $(this).data('emulate');
            var value = $(this).val();

            $(select + ' a').each(function (index, elem) {
                $(elem).toggleClass('selected', (-1 !== $.inArray($(elem).data('value'), value.map(Number))));
            });
        });
    });

    MapInitLocations('map', { lag: 50.85, lng: 4.35 }, @json($locations), function (res, point) {
        var html = new Array();
        $.each(res.data, function (index, elem) {
            html.push('<a href="{{ url('directory') }}/' + elem.id + '"><strong>' + elem.name + '</strong><br>' + elem.entity.name + '</a>');
        });

        offset = 50;
        if (point.x + 200 > $('#map').width()) {
            offset -= 212;
        }

        $('#marker-tooltip').html(html.join('<hr>')).css({
            'left': point.x + offset,
            'top': point.y + 10
        }).show();
    });

    $(window).click(function (e) {
        if ('IMG' !== e.target.tagName) {
            $('#marker-tooltip').hide();
        }
    });

</script>
@endsection
