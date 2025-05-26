@extends('layouts.app')

@section('body_class', 'two-columns')

@section('content')

    <div class="container-fluid bg-yellow mb-3 mb-lg-5 overflow-x">
        <div class="row pt-4 pb-5">
            <div class="col-12">
                <span class="font-lg">{{ __('Los 10 valores para cumplir este objetivo') }}</span>
            </div>
            <div class="col-12">
                <div class="row mt-3">
                    <div class="col-12">
                        <ul class="list-values-big">
                            @foreach ($values as $item)
                                <li>
                                    <img src="{{ $item->imageUrl() }}" alt="{{ $item->name }}" title="{{ $item->name }}">
                                    <span>{{ $item->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::open(['route' => 'demo.index', 'method' => 'post', 'id' => 'filter']) !!}
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-4 col-xl-3">
                    <h1 class="mb-2 d-none d-lg-block">{{ __('Casos demostrativos') }}</h1>
                    <a href="#" class="title d-lg-none" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">{{ __('Filtro') }}</a>
                    <div class="row d-none d-lg-flex">
                        <div class="col-12 mb-2">
                            <label for="countries">{{ __('País') }}</label>
                            {!! Form::select('country_id[]', $data['countries'], $filter['country_id'] ?? null, ['class' => 'form-control form-control-sm select2 emulate-select-invert' . ($errors->has('country_id') ? ' is-invalid' : ''), 'id' => 'countries', 'multiple', 'data-emulate' => '#collapseCountries']) !!}
                        </div>
                        {{-- <div class="col-12 mb-2">
                            <label for="sectors">{{ __('Sector') }}</label>
                            {!! Form::select('sector_id[]', $data['sectors'], $filter['sector_id'] ?? null, ['class' => 'form-control form-control-sm select2 emulate-select-invert' . ($errors->has('sector_id') ? ' is-invalid' : ''), 'id' => 'sectors', 'multiple', 'data-emulate' => '#collapseSectors']) !!}
                        </div> --}}
                        <div class="col-12 mb-2">
                            <label for="values">{{ __('Valor') }}</label>
                            {!! Form::select('value_id[]', $data['values'], $filter['value_id'] ?? null, ['class' => 'form-control form-control-sm select2 emulate-select-invert' . ($errors->has('value_id') ? ' is-invalid' : ''), 'id' => 'values', 'multiple', 'data-emulate' => '#collapseValues']) !!}
                        </div>
                        <div class="col-12 mb-2">
                            <label for="condition_id">{{ __('Estatus') }}</label>
                            {!! Form::select('condition_id', $data['conditions'], $filter['condition_id'] ?? null, ['class' => 'form-control form-control-sm emulate-select-invert' . ($errors->has('condition_id') ? ' is-invalid' : ''), 'id' => 'condition_id', 'placeholder' => '', 'data-emulate' => '#collapseCondition']) !!}
                        </div>
                    </div>
                    <div class="row d-lg-none collapse" id="collapseFilters">
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
                        {{-- <div class="col-12">
                            <a href="#" class="label" data-toggle="collapse" data-target="#collapseSectors" aria-expanded="false" aria-controls="collapseSectors">{{ __('Sector') }}</a>
                            <ul class="list-unstyled collapse emulate-select" id="collapseSectors">
                                @forelse ($data['sectors'] as $value => $text)
                                    <li><a href="#" data-value="{{ $value }}" data-select="#sectors">{{ $text }}</a></li>
                                @empty
                                    <li>{{ __('No se han encontrado sectores') }}</li>
                                @endforelse
                            </ul>
                        </div> --}}
                        <div class="col-12">
                            <a href="#" class="label" data-toggle="collapse" data-target="#collapseValues" aria-expanded="false" aria-controls="collapseValues">{{ __('Valor') }}</a>
                            <ul class="list-unstyled collapse emulate-select" id="collapseValues">
                                @forelse ($data['values'] as $value => $text)
                                    <li><a href="#" data-value="{{ $value }}" data-select="#values">{{ $text }}</a></li>
                                @empty
                                    <li>{{ __('No se han encontrado valores') }}</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="col-12">
                            <a href="#" class="label" data-toggle="collapse" data-target="#collapseCondition" aria-expanded="false" aria-controls="collapseCondition">{{ __('Estatus') }}</a>
                            <ul class="list-unstyled collapse emulate-select" id="collapseCondition">
                                @forelse ($data['conditions'] as $value => $text)
                                    <li><a href="#" data-value="{{ $value }}" data-select="#condition_id">{{ $text }}</a></li>
                                @empty
                                    <li>{{ __('No se ha encontrado estatus') }}</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 col-xl-9">
                    <div class="row mb-lg-4 d-lg-none">
                        <div class="col-12">
                            <h1 class="border-top pt-2">{{ __('Casos demostrativos') }}</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div id="wrapper" style="height: 100%;">
                                @include('demo.list')
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-success mb-0" role="alert">
                                <p>{!! __('Tu papel es clave: visibiliza tu trabajo, conoce el de otros y colabora. Si quieres compartir un caso demostrativo que contribuye a alguno o varios de los 10 valores, utiliza nuestro :link1s formulario :link1e. Normalmente, el caso demostrativo será publicado en unos 5 días. ¡Gracias!', ['link1s' => '<a href="' . route('backend.demo.create') . '">', 'link1e' => '</a>']) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

@endsection

@section('js')

    <script>

        var url = '{{ route('demo.list') }}';
        function filter(params) {
            $.post(url, params, function (res) {
                $('#wrapper').html(res);
            });
        }

        $(function () {

            $('#condition_id').select2({
                allowClear: true,
                closeOnSelect: true,
                minimumResultsForSearch: -1,
                placeholder: ''
            });

            $('#filter select').change(function (e) {
                filter($(this).closest('form').serialize());
            });

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

                if ('string' === typeof value) {
                    value = new Array(value);
                }

                $(select + ' a').each(function (index, elem) {
                    $(elem).toggleClass('selected', (-1 !== $.inArray($(elem).data('value'), value.map(Number))));
                });
            });

            setInterval(function () {
                $('#wrapper .page-link').unbind();
                $('#wrapper .page-link').click(function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var page = getUrlParameter('page', $(this).attr('href'));
                    filter($('#filter').closest('form').serialize() + '&page=' + page);

                    $('html, body').animate({
                        scrollTop: $("#wrapper").offset().top - 150
                    },400);

                    return false;
                });
            }, 500);

        });

    </script>

@endsection
