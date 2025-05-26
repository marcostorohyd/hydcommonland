@if (! empty($directory))
    <div class="row mb-4">
        <div class="col-12">
            @switch ($directory->status_id)
                @case (\App\Status::APPROVED)
                    <div role="alert" class="alert alert-success fade show">
                        <span class="sr-only">success:</span>
                        {{ __('Este usuario/a ha sido aprobado') }}
                    </div>

                    @break

                @case (\App\Status::REFUSED)
                    <div role="alert" class="alert alert-danger fade show">
                        <span class="sr-only">danger:</span>
                        {{ __('Este usuario/a ha sido rechazado') }}
                    </div>

                    @break

                @case (\App\Status::PENDING)
                    <div role="alert" class="alert alert-info fade show">
                        <span class="sr-only">warning:</span>
                        {{ __('Este usuario/a está pendiente de aprobación') }}
                    </div>

                    @break

                @case (\App\Status::CHANGE_REQUEST)
                    <div role="alert" class="alert alert-info fade show">
                        <span class="sr-only">warning:</span>
                        <div class="row">
                            <div class="col">
                                {{ __('Este usuario/a tiene datos de contacto general pendiente de verificar.') }}
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('backend.directory-change.show', $directory->id) }}" class="btn btn-dark">{{ __('Ver solicitud') }}</a>
                            </div>
                        </div>
                    </div>

                    @break

            @endswitch
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 form-group">
            @if (in_array($directory->status_id, [\App\Status::PENDING, \App\Status::REFUSED]))
                <a href="{{ route('backend.directory.approve', $directory->id) }}" class="btn btn-dark btn-lg mr-3">{{ __('Aprobar') }}</a>
            @endif
            @if (in_array($directory->status_id, [\App\Status::PENDING, \App\Status::APPROVED]))
                <a href="{{ route('backend.directory.refuse', $directory->id) }}" class="btn btn-dark btn-lg">{{ __('Rechazar') }}</a>
            @endif
        </div>
        <div class="col-12 col-sm-6 form-group text-sm-right">
            @if (\App\Status::APPROVED == $directory->status_id)
                <a href="{{ route('directory.show', $directory->id) }}" class="btn btn-dark btn-lg">{{ __('Ver') }}</a>
            @endif
            <a href="#" class="btn btn-dark btn-lg ml-3" onclick="directoryDestroy(event);return false;">{{ __('Borrar usuario') }}</a>
        </div>
    </div>
@endif

<h2>{{ __('Editar usuario/a') }}</h2>
<div class="row">
    <div class="col-12 form-group">
        {!! Form::email('user_email', old('user_email', (! empty($user) ? $user->email : '')), ['class' => 'form-control', 'placeholder' => __('Email') . '*', ! empty($directory) ? 'disabled' : '']) !!}
    </div>
    <div class="col-sm-6 form-group">
        {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => __('Contraseña') . '*']) !!}
    </div>
    <div class="col-sm-6 form-group">
        {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => __('Repetir contraseña') . '*']) !!}
    </div>
</div>

<h2>{{ __('Datos de contacto general') }}</h2>
<div class="row">
    <div class="col-12 form-group">
        {!! Form::select('entity_id', $data['entities'], null, ['id' => 'entity_id', 'class' => 'form-control' . ($errors->has('entity_id') ? ' is-invalid' : ''), 'placeholder' => '+ ' . __('Entidad') . '*', 'required']) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('Nombre') . '*', 'required']) !!}
    </div>
    <div class="col-sm-8 form-group">
        {!! Form::email('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => __('Email') . '*', 'required']) !!}
    </div>
    <div class="col-sm-4 form-group">
        {!! Form::text('phone', null, ['class' => 'form-control' . ($errors->has('phone') ? ' is-invalid' : ''), 'placeholder' => __('Teléfono')]) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::text('address', null, ['class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : ''), 'placeholder' => __('Dirección')]) !!}
    </div>
    <div class="col-sm-4 form-group">
        {!! Form::text('zipcode', null, ['class' => 'form-control' . ($errors->has('zipcode') ? ' is-invalid' : ''), 'placeholder' => __('CP') . '*', 'required']) !!}
    </div>
    <div class="col-sm-8 form-group">
        {!! Form::text('city', null, ['class' => 'form-control' . ($errors->has('city') ? ' is-invalid' : ''), 'placeholder' => __('Localidad') . '*', 'required']) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::select('country_id', $data['countries'], null, ['class' => 'form-control' . ($errors->has('country_id') ? ' is-invalid' : ''), 'placeholder' => '+ ' . __('País') . '*', 'required']) !!}
    </div>
    <div class="col-12 form-group">
        <div class="input-group">
            {!! Form::select('sectors[]', $data['sectors'], null, ['class' => 'form-control' . ($errors->has('sectors') ? ' is-invalid' : ''), 'id' => 'sectors', 'required', 'multiple']) !!}
            <div class="input-group-append select-all">
                <img src="{{ asset('svg/icons/all.svg') }}" width="30" height="30">
            </div>
        </div>
    </div>
    <div class="col-12 form-group mb-md-4">
        {!! Form::text('web', null, ['class' => 'form-control' . ($errors->has('web') ? ' is-invalid' : ''), 'placeholder' => __('Web')]) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::text('facebook', null, ['class' => 'form-control' . ($errors->has('facebook') ? ' is-invalid' : ''), 'placeholder' => 'Facebook']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::text('twitter', null, ['class' => 'form-control' . ($errors->has('twitter') ? ' is-invalid' : ''), 'placeholder' => 'Twitter']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::text('instagram', null, ['class' => 'form-control' . ($errors->has('instagram') ? ' is-invalid' : ''), 'placeholder' => 'Instagram']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::text('linkedin', null, ['class' => 'form-control' . ($errors->has('linkedin') ? ' is-invalid' : ''), 'placeholder' => 'Linkedin']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::text('tiktok', null, ['class' => 'form-control' . ($errors->has('tiktok') ? ' is-invalid' : ''), 'placeholder' => 'TikTok']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::text('youtube', null, ['class' => 'form-control' . ($errors->has('youtube') ? ' is-invalid' : ''), 'placeholder' => 'YouTube']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::text('vimeo', null, ['class' => 'form-control' . ($errors->has('vimeo') ? ' is-invalid' : ''), 'placeholder' => 'Vimeo']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::text('whatsapp', null, ['class' => 'form-control' . ($errors->has('whatsapp') ? ' is-invalid' : ''), 'placeholder' => 'WhatsApp']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::text('telegram', null, ['class' => 'form-control' . ($errors->has('telegram') ? ' is-invalid' : ''), 'placeholder' => 'Telegram']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::text('research_gate', null, ['class' => 'form-control' . ($errors->has('research_gate') ? ' is-invalid' : ''), 'placeholder' => 'Research Gate']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::text('orcid', null, ['class' => 'form-control' . ($errors->has('orcid') ? ' is-invalid' : ''), 'placeholder' => 'ORCID']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::text('academia_edu', null, ['class' => 'form-control' . ($errors->has('academia_edu') ? ' is-invalid' : ''), 'placeholder' => 'Academia.edu']) !!}
    </div>
</div>

<div id="person_contact" style="{{ 1 == old('entity_id', ! empty($directory) ? $directory->entity_id : 0) ? 'display: none;' : '' }}">
    <h2>{{ __('Datos persona de contacto') }}</h2>
    <div class="row">
        <div class="col-12 form-group">
            {!! Form::text('contact_name', null, ['class' => 'form-control' . ($errors->has('contact_name') ? ' is-invalid' : ''), 'placeholder' => __('Nombre')]) !!}
        </div>
        <div class="col-sm-8 form-group">
            {!! Form::email('contact_email', null, ['class' => 'form-control' . ($errors->has('contact_email') ? ' is-invalid' : ''), 'placeholder' => __('Email')]) !!}
        </div>
        <div class="col-sm-4 form-group">
            {!! Form::text('contact_phone', null, ['class' => 'form-control' . ($errors->has('contact_phone') ? ' is-invalid' : ''), 'placeholder' => __('Teléfono')]) !!}
        </div>
    </div>
</div>

<div id="additional_info" style="{{ 1 == old('entity_id', ! empty($directory) ? $directory->entity_id : 0) ? 'display: none;' : '' }}">
    <h2>{{ __('Información adicional') }}</h2>
    <div class="row">
        <div class="col-12 form-group">
            {!! Form::number('partners', null, ['class' => 'form-control' . ($errors->has('partners') ? ' is-invalid' : ''), 'placeholder' => __('Nº de socios/as'), 'min' => 0]) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::number('members', null, ['class' => 'form-control' . ($errors->has('members') ? ' is-invalid' : ''), 'placeholder' => __('Nº de comuneras/os'), 'min' => 0]) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::number('represented', null, ['class' => 'form-control' . ($errors->has('represented') ? ' is-invalid' : ''), 'placeholder' => __('Número de personas representadas'), 'min' => 0]) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::number('surface', null, ['class' => 'form-control' . ($errors->has('surface') ? ' is-invalid' : ''), 'placeholder' => __('Superficie'), 'min' => 0]) !!}
        </div>
    </div>
</div>

<h2>{{ __('Descripción') }}*</h2>
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
                {!! Form::textarea($lang . '[description]', old($lang . '.description', ! empty($directory) ? $directory->translate($lang)->description : ''), ['class' => 'form-control description' . ($errors->has($lang . '.description') ? ' is-invalid' : ''), 'placeholder' => __('Escribe algo...')]) !!}
            </div>
        @endforeach
    </div>
</div>

<h2>{{ __('Logotipo / fotografía') }} <small>({{ \App\Media::humanize(\App\User::IMAGE_ALLOWED) }} {{ __('tamaño máx. :size MB.', ['size' => \App\User::IMAGE_MAX_SIZE / 1000]) }})</small></h2>
<div class="row">
    <div class="col-12 form-group">
        <div id="dropzone" class="dropzone {{ $errors->has('image') ? ' is-invalid' : '' }}">
            <div class="dz-default dz-message">
                <span>
                    <em class="fa fa-upload text-muted"></em>
                    <br>{{ __('Arrastra el archivo aquí para subirlo') }}
                </span>
            </div>
            <div class="fallback">
                {!! Form::file('file', ['class' => 'form-control' . ($errors->has('image') ? ' is-invalid' : ''), 'accept' => \App\User::IMAGE_ALLOWED]) !!}
            </div>
        </div>
        {!! Form::hidden('image', null, ['id' => 'image']) !!}
        {!! Form::hidden('image_is_new', null, ['id' => 'image_is_new']) !!}
    </div>
</div>

{!! Form::hidden('latitude', null, ['id' => 'latitude']) !!}
{!! Form::hidden('longitude', null, ['id' => 'longitude']) !!}

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" integrity="sha256-ADCoAb8+4Q0aUjknVls52/iuqleXITKP65owZtLSGBI=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/basic.min.css" integrity="sha256-RvDmZ4ZtPtrWmZdibCa80jCE32m21xuR5SuW6zfJaW4=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" integrity="sha256-e47xOkXs1JXFbjjpoRr1/LhVcqSzRmGmPqsrUQeVs+g=" crossorigin="anonymous" />
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.min.js" integrity="sha256-EqzdHRQ0S25bXoh1W7841pzdUUgmlUk90Ov1Ckj1nk4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/lang/summernote-es-ES.min.js" integrity="sha256-lSdhACt5P3B9W+uMy6BRXP3YJaY1poz40DlTQaTnAko=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js" integrity="sha256-cs4thShDfjkqFGk5s2Lxj35sgSRr4MRcyccmi0WKqCM=" crossorigin="anonymous"></script>
<script>
    Dropzone.autoDiscover = false;

    $(function() {
        $('#entity_id').change(function (e) {
            $('[name="partners"]').parent().toggle(-1 !== $.inArray($(this).val()-0, [6]));
            $('[name="members"]').parent().toggle(-1 === $.inArray($(this).val()-0, [6,8]));
            $('[name="represented"]').parent().toggle(8 === $(this).val()-0);
            $('[name="surface"]').parent().toggle(-1 !== $.inArray($(this).val()-0, [4,8]));
            $('#person_contact').toggle(-1 === $.inArray($(this).val()-0, [0,1]));
            $('#additional_info').toggle(-1 === $.inArray($(this).val()-0, [0,1,2,3]));
        }).trigger('change');

        $('#sectors').select2({
            placeholder: '+ {{ __('Sector') }}'
        });

        $('.description').summernote(
            $.extend(true, {
                height: ((992 >= $(window).width()) ? '250px' : '350px'),
                callbacks: {
                    onInit: function () {
                        if ($(this).hasClass('is-invalid')) {
                            $(this).next().addClass('is-invalid');
                        }
                    },
                    onChange: function () {
                        $(this).parent().find('.note-editable *').removeAttributes();
                    }
                }
            }, summernote_ops)
        );

        var myDropzone = new Dropzone('#dropzone', {
            acceptedFiles: @json(\App\User::IMAGE_ALLOWED),
            url: '{{ route('tool.image-upload') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            params: { id: '{{ uniqid() }}' },
            uploadMultiple: false,
            parallelUploads: 1,
            maxFiles: 1,
            maxFilesize: @json(\App\User::IMAGE_MAX_SIZE / 1000),
            addRemoveLinks: true,
            dictRemoveFile: '{{ __('Eliminar imagen') }}',
            dictFileTooBig: '{{ __('La imagen es mayor de :size MB', ['size' => \App\User::IMAGE_MAX_SIZE / 1000]) }}',
            timeout: 10000,
            thumbnailWidth: 1200,
            thumbnailHeight: 250,
            init: function () {
                this.on('addedfile', function() {
                    if (null != this.files[1]) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            success: function (file, done) {
                $('#image').val(done.path);
                $('#image_is_new').val(1);
            },
            error: function (file, res) {
                $(file.previewElement).addClass('dz-error').find('.dz-error-message').text(res.error);
            },
            removedfile: function(file) {
                $('#image').val('');
                $('#image_is_new').val('');
                file.previewElement.remove();
                // $('.dz-started').removeClass('dz-started');
            }
        });

        var flag = false;
        $('#form').submit(function (e) {
            if (flag) {
                return true;
            }
            e.preventDefault();
            flag = false;
            loading();

            var address = new Array();
            var elems = new Array('address', 'zipcode', 'city', 'country_id');
            $.each(elems, function (index, value) {
                if ('country_id' == value) {
                    address.push($('[name="' + value + '"] option:selected').html());
                } else {
                    address.push($('[name="' + value + '"]').val());
                }
            });

            address = address.filter(address => address.length);
            var params = { address: address.join(',') };
            $.post('{{ route('tool.map_search') }}', params, function (res) {
                $('#latitude').val(res.data.latitude);
                $('#longitude').val(res.data.longitude);
            }).fail(function () {
                $('#latitude').val('');
                $('#longitude').val('');
            }).always(function () {
                flag = true;
                $('#form').submit();
            });

            return false;
        });

        // Fill image
        @if ($image = old('image', ! empty($directory->image)))
            var image = { name: '', size: ''};
            myDropzone.emit('addedfile', image);
            myDropzone.emit('thumbnail', image, '{{ old('image', (! empty($directory->image) ? $directory->imageUrl() : '')) }}');
            myDropzone.emit('complete', image);
            myDropzone.files.push(image);
        @endif
    });

    @if (! empty($directory))
        function directoryDestroy(e) {
            e.preventDefault();

            if (! confirm('Se va a borrar de forma definitiva el usuario seleccionado. ¿Continuar?')) {
                return;
            }

            window.location.href = '{{ route('backend.directory.delete', $directory->id) }}';
        }
    @endif

</script>
@endsection
