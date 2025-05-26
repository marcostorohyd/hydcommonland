@extends('backend.layouts.app')

@section('title', __('Usuarios/as'))

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('backend.directory.create') }}" class="btn btn-dark btn-lg" title="{{ __('Nuevo registro') }}">{{ __('Nuevo registro') }}</a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table id="datatable-filter" class="table table-hover datatables m-t">
                <colgroup>
                    <col />
                    <col width="200"/>
                    <col width="150"/>
                    <col />
                    <col width="120"/>
                    <col width="80"/>
                </colgroup>
                <thead>
                    <tr>
                        <th>{{ __('Nombre') }}</th>
                        <th>{{ __('Entidad') }}</th>
                        <th>{{ __('País') }}</th>
                        <th>{{ __('Sector') }}</th>
                        <th>{{ __('Estado') }}</th>
                        <th>{{ __('Opciones') }}</th>
                    </tr>
                    <tr>
                        <th>
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('- Todos/as -'), 'autocomplete' => 'off']) !!}
                        </th>
                        <th>
                            {!! Form::select('entity_id', $data['entities'], null, ['id' => 'entity_id', 'class' => 'form-control', 'placeholder' => __('- Todas -')]) !!}
                        </th>
                        <th>
                            {!! Form::select('country_id', $data['countries'], null, ['class' => 'form-control', 'placeholder' => __('- Todos -')]) !!}
                        </th>
                        <th>
                            {!! Form::select('sectors', $data['sectors'], null, ['class' => 'form-control', 'placeholder' => __('- Todos -')]) !!}
                        </th>
                        <th>
                            {!! Form::select('status_id', $data['statuses'], null, ['class' => 'form-control', 'placeholder' => __('- Todos -')]) !!}
                        </th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('js/directory.js') }}?{{ config('commonlandsnet.version') }}"></script>
<script type="text/javascript">
    $(function() {
        var data = @json($request);

        var timeout = false;
        $('#datatable-filter input').keyup(function (e) {
            var $element = $(this);
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                data[$element.attr('name')] = $element.val();
                oTable.ajax.reload();
            }, 500);
        });

        $('#datatable-filter select').change(function (index, item) {
            data[$(this).attr('name')] = $(this).val();
            oTable.ajax.reload();
        });

        ops = {
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('backend.directory.datatable') }}',
                method: 'POST',
                data: function (d) {
                    return $.extend(d, data);
                },
                dataSrc: function (json) {
                    return json.data;
                }
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'entity', name: 'entity' },
                { data: 'country', name: 'country' },
                { data: 'sectors', name: 'sectors' },
                { data: 'status', name: 'status' },
                { data: 'id', name: 'id' }
            ],
            columnDefs: [{
                targets: [1,2],
                render: function ( data, type, row ) {
                    return data.name;
                }
            }, {
                targets: 3,
                render: function ( data, type, row ) {
                    var sectors = new Array();
                    for (let index = 0; index < data.length; index++) {
                        sectors.push(data[index].name);
                    }
                    return sectors.join(', ');
                }
            }, {
                targets: 4,
                class: 'text-center',
                render: function ( data, type, row ) {
                    return '<span class="badge badge-primary" style="background-color: #' + data.color + '">' + data.name + '</span>';
                }
            }, {
                targets: -1,
                orderable: false,
                class: 'text-center',
                render: function ( data, type, row ) {
                    var html = '<a class="mr-3" href="/backend/directory/' + data + '/edit" title="{{__('Editar usuario') }}"><i class="icon icon-pencil icon-md"></i></a>';
                    html += '<a onclick="directoryDestroy(' + data + ');return false;" href="#" title="{{__('Borrar usuario') }}"><i class="icon icon-trash icon-md"></i></a>';
                    return html;
                },
            }],
            ordering: false
        };

        oTable = $('#datatable-filter').DataTable($.extend(true, ops, datatables_ops));

        $('#paginate-wrapper').append($('.dataTables_paginate'));
    });

</script>
@endsection
