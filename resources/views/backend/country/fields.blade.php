<div class="row">
    <div class="col-12 form-group lang-group">
        <div class="lang-buttons">
            @foreach (locales(true) as $lang => $language)
                <a href="#" class="btn-lang" data-lang="{{ $lang }}">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 19.26 26.25"><defs><style>.cls-1,.cls-3{fill:none;}.cls-2{clip-path:url(#clip-path);}.cls-3{stroke:#3c3c3b;stroke-linecap:round;stroke-miterlimit:10;stroke-width:2px;}.cls-4{font-size:8px;fill:#3c3c3b;font-family:Montserrat-Regular, Montserrat;}</style><clipPath id="clip-path"><rect class="cls-1" width="19.26" height="26.6"/></clipPath></defs><title>{{ $language }}</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g class="cls-2"><path class="cls-3" d="M18.25,13.25l-1.51.44a9.37,9.37,0,0,1-2.8.46,8.8,8.8,0,0,1-2.8-.46l-3-1a8.72,8.72,0,0,0-5.61,0L1,13.18V2l1.51-.51a8.72,8.72,0,0,1,5.61,0l3,1a8.8,8.8,0,0,0,2.8.46,9.36,9.36,0,0,0,2.8-.46L18.26,2v11.2ZM1,13.18V23.9"/><text class="cls-4" transform="translate(4.76 24.25)">{{ $language }}</text></g></g></g></svg>
                </a>
            @endforeach
        </div>
        @foreach (locales() as $lang)
            <div class="lang" lang="{{ $lang }}">
                {!! Form::text($lang . '[name]', old($lang . '.name', ! empty($country) ? $country->translate($lang)->name : ''), ['class' => 'form-control name' . ($errors->has($lang . '.name') ? ' is-invalid' : ''), 'placeholder' => __('Nombre') . '*']) !!}
            </div>
        @endforeach
    </div>
    <div class="col-12 form-group">
        {!! Form::select('contact_id', $data['directories'], null, ['id' => 'directory_id', 'class' => 'form-control' . ($errors->has('contact_id') ? ' is-invalid' : ''), 'placeholder' => __('Contacto'), 'required']) !!}
    </div>
</div>

@section('js')
<script>
    $(function() {
        $('#directory_id').select2({
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
                            obj.text = obj.name_with_status;
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
            allowClear: true,
            placeholder: '{{ __('Contacto') }}'
        });
    });
</script>
@endsection
