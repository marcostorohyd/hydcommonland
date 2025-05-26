@extends('layouts.app')

@section('body_class', 'two-columns')

@section('content')
{!! Form::open(['route' => 'event.index', 'method' => 'post', 'id' => 'filter']) !!}
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-4 col-xl-3">
                <h1 class="mb-2 d-none d-lg-block">{{ __('Eventos') }}</h1>
                <a href="#" class="title d-lg-none" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">{{ __('Filtro') }}</a>
                <div class="row d-none d-lg-flex">
                    <div class="col-12 mb-2">
                        <label for="">{{ __('Tipo') }}</label>
                        {!! Form::select('type_id[]', $data['types'], null, ['class' => 'form-control form-control-sm select2 emulate-select-invert' . ($errors->has('type_id') ? ' is-invalid' : ''), 'id' => 'types', 'multiple', 'data-emulate' => '#collapseTypes']) !!}
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
                        <a href="#" class="label" data-toggle="collapse" data-target="#collapseTypes" aria-expanded="false" aria-controls="collapseTypes">{{ __('Tipo') }}</a>
                        <ul class="list-unstyled collapse emulate-select" id="collapseTypes">
                            @forelse ($data['types'] as $value => $text)
                                <li><a href="#" data-value="{{ $value }}" data-select="#types">{{ $text }}</a></li>
                            @empty
                                {{ __('No se han encontrado tipos') }}
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
                <div class="row mb-lg-4 d-lg-none">
                    <div class="col-12">
                        <h1 class="border-top pt-2">{{ __('Eventos') }}</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table id="datatable-filter" class="table table-hover datatables datatables-click m-t">
                            <thead>
                                <tr>
                                    <th>{{ __('Fecha') }}</th>
                                    <th>{{ __('Evento') }}</th>
                                    <th>{{ __('País') }}</th>
                                    <th>{{ __('Tipo') }}</th>
                                    <th>{{ __('Sector') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-primary mb-0" role="alert">
                            <p>{!! __('Tu papel es clave: visibiliza tu trabajo, conoce el de otros y colabora. Si estás organizando un evento que te gustaría compartir con la plataforma, utiliza nuestro :link1s formulario :link1e. Normalmente, el evento se publicará en el calendario en unos 5 días. Recuerda que necesitas :link2s registrarte :link2e en el directorio de la plataforma para poder compartir eventos.', ['link1s' => '<a href="' . route('backend.event.create') . '">', 'link1e' => '</a>', 'link2s' => '<a href="' . route('register') . '">', 'link2e' => '</a>']) !!}</p>
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
    $(function () {
        $('#filter select').change(function (e) {
            $('#datatable-filter').DataTable().ajax.reload();
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

            $(select + ' a').each(function (index, elem) {
                $(elem).toggleClass('selected', (-1 !== $.inArray($(elem).data('value'), value.map(Number))));
            });
        });

        ops = {
            serverSide: true,
            ajax: {
                url: '{{ route('event.datatable') }}',
                method: 'POST',
                data: function (d) {
                    return $.extend(d, $('#filter').serializeObject());
                },
                dataSrc: function (json) {
                    return json.data;
                }
            },
            columns: [
                { data: 'start', name: 'start' },
                { data: 'name', name: 'name' },
                { data: 'country', name: 'country' },
                { data: 'type', name: 'type' },
                { data: 'sectors', name: 'sectors' },
            ],
            columnDefs: [{
                targets: 0,
                class: 'text-lg-nowrap',
                render: function ( data, type, row ) {
                    var html = moment(data).format('L');
                    return (row.end) ? html + '&nbsp;- ' + moment(row.end).format('L') : html;
                }
            }, {
                targets: 1,
                class: 'font-weight-bold',
                render: function ( data, type, row ) {
                    return '<a href="/event/' + row.id + '">' + data + '</a>';
                }
            }, {
                targets: [2,3],
                class: 'text-lg-nowrap',
                render: function ( data, type, row ) {
                    return (data) ? data.name : '';
                }
            }, {
                targets: -1,
                render: function ( data, type, row ) {
                    var sectors = new Array();
                    for (let index = 0; index < data.length; index++) {
                        sectors.push(data[index].name);
                    }
                    return sectors.join('/');
                }
            }],
            ordering: false
        };

        oTable = $('#datatable-filter').DataTable($.extend(true, ops, datatables_ops));

        $('#datatable-filter tbody').on('click', 'tr', function () {
            var data = oTable.row(this).data();
            window.location.href = '/event/' + data.id;
        } );

        $('#paginate-wrapper').append($('.dataTables_paginate'));
    });
</script>
@endsection
