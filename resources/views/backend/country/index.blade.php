@extends('backend.layouts.app')

@section('title', __('Países'))

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('backend.country.create') }}" class="btn btn-dark btn-lg" title="{{ __('Nuevo registro') }}">{{ __('Nuevo país') }}</a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table id="datatable-filter" class="table table-hover datatables m-t">
                <colgroup>
                    <col />
                    <col />
                    <col width="80"/>
                </colgroup>
                <thead>
                    <tr>
                        <th>{{ __('País') }}</th>
                        <th>{{ __('Contacto') }}</th>
                        <th>{{ __('Opciones') }}</th>
                    </tr>
                    <tr>
                        <th>
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('- Todos -'), 'autocomplete' => 'off']) !!}
                        </th>
                        <th>
                            {!! Form::select('contact_id', $data['directories'], null, ['id' => 'contact_id', 'class' => 'form-control form-control-sm', 'placeholder' => __('- Todos -')]) !!}
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
<script src="{{ url('js/country.js') }}?{{ config('commonlandsnet.version') }}"></script>
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
                url: '{{ route('backend.country.datatable') }}',
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
                { data: 'contact', name: 'contact' },
                { data: 'id', name: 'id' }
            ],
            columnDefs: [{
                targets: 1,
                render: function ( data, type, row ) {
                    return (data) ? data.name_with_status : '';
                }
            }, {
                targets: -1,
                orderable: false,
                class: 'text-right',
                render: function ( data, type, row ) {
                    var html = '';
                    if (row.contact) {
                        html += '<a href="#" onclick="countryUnassignContact(' + data + ');return false;" class="mr-3" title="{{ __('Borrar contacto') }}"><i class="icon icon-user-del icon-md"></i></a>';
                    }
                    html += '<a class="mr-3" href="/backend/country/' + data + '/edit" title="{{ __('Editar país') }}"><i class="icon icon-pencil icon-md"></i></a>';
                    html += '<a onclick="countryDestroy(' + data + ');return false;" href="#" title="Borrar país"><i class="icon icon-trash icon-md"></i></a>';
                    return html;
                },
            }],
            ordering: false
        };

        oTable = $('#datatable-filter').DataTable($.extend(true, ops, datatables_ops));

        $('#paginate-wrapper').append($('.dataTables_paginate'));

        $('#contact_id').select2({
            ajax: {
                delay: 250,
                url: '{{ route('backend.directory.search') }}',
                method: 'POST',
                data: function (params) {
                    var query = {
                        search: params.term,
                    }
                    return query;
                },
                processResults: function (res) {
                    // Tranforms the top-level key of the response object from 'items' to 'results'
                    if (res) {
                        var data = $.map(res, function (obj) {
                            obj.id = obj.id;
                            obj.text = obj.name;
                            return obj;
                        });
                        return {
                            results: data
                        };
                    }

                    return {
                        results: ''
                    };
                }
            },
            minimumInputLength: 3,
        });
    });

</script>
@endsection
