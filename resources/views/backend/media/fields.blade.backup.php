@if (! empty($media))
    <div class="row mb-4">
        <div class="col-12">
            @switch($media->status_id)
                @case(\App\Status::APPROVED)
                    <div role="alert" class="alert alert-success fade show">
                        <span class="sr-only">success:</span>
                        {{ __('Esta mediateca ha sido aprobada') }}
                    </div>

                    @break

                @case(\App\Status::REFUSED)
                    <div role="alert" class="alert alert-danger fade show">
                        <span class="sr-only">danger:</span>
                        {{ __('Esta mediateca ha sido rechazada') }}
                    </div>

                    @break

                @default
                    <div role="alert" class="alert alert-info fade show">
                        <span class="sr-only">warning:</span>
                        {{ __('Esta mediateca está pendiente de aprobación') }}
                    </div>

            @endswitch
        </div>
    </div>
    <div class="row">
        <div class="col-12 form-group">
            @if (in_array($media->status_id, [\App\Status::PENDING, \App\Status::REFUSED]))
                <a href="{{ route('backend.media.approve', $media->id) }}" class="btn btn-dark btn-lg mr-3" type="submit">{{ __('Aprobar') }}</a>
            @endif
            @if (in_array($media->status_id, [\App\Status::PENDING, \App\Status::APPROVED]))
                <a href="{{ route('backend.media.refuse', $media->id) }}" class="btn btn-dark btn-lg" type="submit">{{ __('Rechazar') }}</a>
            @endif
        </div>
    </div>
@endif

<h2>{{ __('Datos de la noticia') }}</h2>
<div class="row">
    <div class="col-12 form-group">
        {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('Título') . '*', 'required']) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::text('date', old('date', ! empty($media->date) ? $media->date->format('Y-m-d') : ''), ['class' => 'form-control date' . ($errors->has('date') ? ' is-invalid' : ''), 'placeholder' => __('Fecha') . '*', 'required']) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::select('country_id', $data['countries'], null, ['class' => 'form-control' . ($errors->has('country_id') ? ' is-invalid' : ''), 'placeholder' => '+ ' . __('País') . '*', 'required']) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::select('sectors[]', $data['sectors'], null, ['class' => 'form-control' . ($errors->has('sectors') ? ' is-invalid' : ''), 'id' => 'sectors', 'required', 'multiple']) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::text('author', null, ['class' => 'form-control' . ($errors->has('author') ? ' is-invalid' : ''), 'placeholder' => __('Autor')]) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::email('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => __('Contacto (email)')]) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::select('format_id', $data['formats'], null, ['class' => 'form-control' . ($errors->has('format_id') ? ' is-invalid' : ''), 'id' => 'format_id', 'placeholder' => '+ ' . __('Formato') . '*', 'required']) !!}
    </div>
</div>

<h2>{{ __('Foto de portada') }}*</h2>
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
                {!! Form::file('file', ['class' => 'form-control' . ($errors->has('image') ? ' is-invalid' : ''), 'accept' => \App\MediaLibrary::IMAGE_ALLOWED]) !!}
            </div>
        </div>
        {!! Form::hidden('image', old('image', (! empty($media->image) ? $media->imageUrl() : '')), ['id' => 'image']) !!}
        {!! Form::hidden('image_is_new', null, ['id' => 'image_is_new']) !!}
    </div>
</div>

<h2 class="format format-1">{{ __('Video') }}*</h2>
<div class="row format format-1">
    <div class="col-12 form-group">
        {!! Form::url('link', null, ['class' => 'form-control' . ($errors->has('link') ? ' is-invalid' : ''), 'placeholder' => __('Vimeo / YouTube (link)')]) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::number('length', null, ['class' => 'form-control' . ($errors->has('length') ? ' is-invalid' : ''), 'placeholder' => __('Duración (en minutos)'), 'min' => 0, 'max' => 99999]) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::select('tags[]', $data['tags'], null, ['class' => 'form-control tags' . ($errors->has('tags') ? ' is-invalid' : ''), 'multiple']) !!}
    </div>
</div>

<h2 class="format format-2">{{ __('Galería de fotos') }}*</h2>
<div class="row format format-2">
    <div class="col-12 form-group">
        <div id="gallery" class="dropzone dropzone-gallery {{ $errors->has('gallery') ? ' is-invalid' : '' }}">
            <div class="dz-default dz-message">
                <span>
                    <em class="fa fa-upload text-muted"></em>
                    <br>{{ __('Arrastra el archivo aquí para subirlo') }}
                </span>
            </div>
            <div class="fallback">
                {!! Form::file('file', ['class' => 'form-control' . ($errors->has('gallery') ? ' is-invalid' : ''), 'accept' => \App\MediaLibrary::IMAGE_ALLOWED, 'multiple']) !!}
            </div>
        </div>
        <div id="gallery-input">
            @if ($gallery_remove = old('gallery_remove'))
                @foreach ($gallery_remove as $item)
                    <input type="hidden" name="gallery_remove[]" value="{{ $item }}">
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-12 form-group">
        {!! Form::select('tags[]', $data['tags'], null, ['class' => 'form-control tags' . ($errors->has('tags') ? ' is-invalid' : ''), 'multiple']) !!}
    </div>
</div>

<h2 class="format format-3">{{ __('Presentación power point') }}* <small>({{ __('Tamaño máx. :size MB.', ['size' => \App\MediaLibrary::PRESENTATION_MAX_SIZE / 1000]) }})</small></h2>
<div class="row format format-3">
    <div class="col-12 form-group">
        <div class="form-control-plaintext">
            <div class="row">
                <div class="col-auto pl-1 pr-4">
                    <label class="form-control-lg" for="">{{ __('Elije entre') }}</label>
                </div>
                <div class="col-auto px-4">
                    <div class="custom-control custom-radio custom-radio-to-checkbox">
                        {!! Form::radio('external', 0, null, ['class' => 'custom-control-input' . ($errors->has('external') ? ' is-invalid' : ''), 'id' => 'type_file_3']) !!}
                        <label class="custom-control-label" for="type_file_3">
                            {{ __('Subir un archivo') }}
                        </label>
                    </div>
                </div>
                <div class="col-auto px-4">
                    <div class="custom-control custom-radio custom-radio-to-checkbox">
                        {!! Form::radio('external', 1, null, ['class' => 'custom-control-input' . ($errors->has('external') ? ' is-invalid' : ''), 'id' => 'type_link_3']) !!}
                        <label class="custom-control-label" for="type_link_3">
                            {{ __('Link externo') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 form-group link">
        {!! Form::url('link', null, ['class' => 'form-control' . ($errors->has('link') ? ' is-invalid' : ''), 'placeholder' => __('Link')]) !!}
    </div>
    <div class="col-12 form-group file">
        <div id="presentation-dropzone" class="dropzone dropzone-file {{ $errors->has('presentation') ? ' is-invalid' : '' }}">
            <div class="dz-default dz-message">
                <span>
                    <em class="fa fa-upload text-muted"></em>
                    <br>{{ __('Arrastra el archivo aquí para subirlo') }}
                </span>
            </div>
            <div class="fallback">
                {!! Form::file('file', ['class' => 'form-control' . ($errors->has('presentation') ? ' is-invalid' : ''), 'accept' => \App\MediaLibrary::PRESENTATION_ALLOWED, 'multiple']) !!}
            </div>
        </div>
        <div id="presentation-input">
            @if ($presentation_remove = old('presentation_remove'))
                @foreach ($presentation_remove as $item)
                    <input type="hidden" name="presentation_remove[]" value="{{ $item }}">
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-12 form-group">
        {!! Form::select('tags[]', $data['tags'], null, ['class' => 'form-control tags' . ($errors->has('tags') ? ' is-invalid' : ''), 'multiple']) !!}
    </div>
</div>

<h2 class="format format-4">{{ __('Documentos') }}* <small>({{ __('Tamaño máx. :size MB.', ['size' => \App\MediaLibrary::DOCUMENT_MAX_SIZE / 1000]) }})</small></h2>
<div class="row format format-4">
    <div class="col-12 form-group">
        <div class="form-control-plaintext">
            <div class="row">
                <div class="col-auto pl-1 pr-4">
                    <label class="form-control-lg" for="">{{ __('Elije entre') }}</label>
                </div>
                <div class="col-auto px-4">
                    <div class="custom-control custom-radio custom-radio-to-checkbox">
                        {!! Form::radio('external', 0, null, ['class' => 'custom-control-input' . ($errors->has('external') ? ' is-invalid' : ''), 'id' => 'type_file_4']) !!}
                        <label class="custom-control-label" for="type_file_4">
                            {{ __('Subir un archivo') }}
                        </label>
                    </div>
                </div>
                <div class="col-auto px-4">
                    <div class="custom-control custom-radio custom-radio-to-checkbox">
                        {!! Form::radio('external', 1, null, ['class' => 'custom-control-input' . ($errors->has('external') ? ' is-invalid' : ''), 'id' => 'type_link_4']) !!}
                        <label class="custom-control-label" for="type_link_4">
                            {{ __('Link externo') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 form-group link">
        {!! Form::url('link', null, ['class' => 'form-control' . ($errors->has('link') ? ' is-invalid' : ''), 'placeholder' => __('Link')]) !!}
    </div>
    <div class="col-12 form-group file">
        <div id="document-dropzone" class="dropzone dropzone-file {{ $errors->has('document') ? ' is-invalid' : '' }}">
            <div class="dz-default dz-message">
                <span>
                    <em class="fa fa-upload text-muted"></em>
                    <br>{{ __('Arrastra el archivo aquí para subirlo') }}
                </span>
            </div>
            <div class="fallback">
                {!! Form::file('file', ['class' => 'form-control' . ($errors->has('document') ? ' is-invalid' : ''), 'accept' => \App\MediaLibrary::DOCUMENT_ALLOWED, 'multiple']) !!}
            </div>
        </div>
        <div id="document-input">
            @if ($document_remove = old('document_remove'))
                @foreach ($document_remove as $item)
                    <input type="hidden" name="document_remove[]" value="{{ $item }}">
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-12 form-group">
        {!! Form::number('length', null, ['class' => 'form-control' . ($errors->has('length') ? ' is-invalid' : ''), 'placeholder' => __('Número de páginas'), 'min' => 0, 'max' => 99999]) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::select('tags[]', $data['tags'], null, ['class' => 'form-control tags' . ($errors->has('tags') ? ' is-invalid' : ''), 'multiple']) !!}
    </div>
</div>

<h2 class="format format-5">{{ __('Audios') }}* <small>({{ __('Tamaño máx. :size MB.', ['size' => \App\MediaLibrary::AUDIO_MAX_SIZE / 1000]) }})</small></h2>
<div class="row format format-5">
    <div class="col-12 form-group">
        <div class="form-control-plaintext">
            <div class="row">
                <div class="col-auto pl-1 pr-4">
                    <label class="form-control-lg" for="">{{ __('Elije entre') }}</label>
                </div>
                <div class="col-auto px-4">
                    <div class="custom-control custom-radio custom-radio-to-checkbox">
                        {!! Form::radio('external', 0, null, ['class' => 'custom-control-input' . ($errors->has('external') ? ' is-invalid' : ''), 'id' => 'type_file_5']) !!}
                        <label class="custom-control-label" for="type_file_5">
                            {{ __('Subir un archivo') }}
                        </label>
                    </div>
                </div>
                <div class="col-auto px-4">
                    <div class="custom-control custom-radio custom-radio-to-checkbox">
                        {!! Form::radio('external', 1, null, ['class' => 'custom-control-input' . ($errors->has('external') ? ' is-invalid' : ''), 'id' => 'type_link_5']) !!}
                        <label class="custom-control-label" for="type_link_5">
                            {{ __('Link externo') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 form-group link">
        {!! Form::url('link', null, ['class' => 'form-control' . ($errors->has('link') ? ' is-invalid' : ''), 'placeholder' => __('Link')]) !!}
    </div>
    <div class="col-12 form-group file">
        <div id="audio-dropzone" class="dropzone dropzone-file {{ $errors->has('audio') ? ' is-invalid' : '' }}">
            <div class="dz-default dz-message">
                <span>
                    <em class="fa fa-upload text-muted"></em>
                    <br>{{ __('Arrastra el archivo aquí para subirlo') }}
                </span>
            </div>
            <div class="fallback">
                {!! Form::file('file', ['class' => 'form-control' . ($errors->has('audio') ? ' is-invalid' : ''), 'accept' => \App\MediaLibrary::AUDIO_ALLOWED, 'multiple']) !!}
            </div>
        </div>
        <div id="audio-input">
            @if ($audio_remove = old('audio_remove'))
                @foreach ($audio_remove as $item)
                    <input type="hidden" name="audio_remove[]" value="{{ $item }}">
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-12 form-group">
        {!! Form::number('length', null, ['class' => 'form-control' . ($errors->has('length') ? ' is-invalid' : ''), 'placeholder' => __('Duración (en minutos)'), 'min' => 0, 'max' => 99999]) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::select('tags[]', $data['tags'], null, ['class' => 'form-control tags' . ($errors->has('tags') ? ' is-invalid' : ''), 'multiple']) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        <p>* {{ __('Campos requeridos') }}</p>
    </div>
</div>

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/basic.min.css" integrity="sha256-RvDmZ4ZtPtrWmZdibCa80jCE32m21xuR5SuW6zfJaW4=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" integrity="sha256-e47xOkXs1JXFbjjpoRr1/LhVcqSzRmGmPqsrUQeVs+g=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha256-rByPlHULObEjJ6XQxW/flG2r+22R5dKiAoef+aXWfik=" crossorigin="anonymous" />
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js" integrity="sha256-cs4thShDfjkqFGk5s2Lxj35sgSRr4MRcyccmi0WKqCM=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM=" crossorigin="anonymous"></script>
<script>
    Dropzone.autoDiscover = false;

    $(function() {
        $('#sectors').select2({
            placeholder: '+ {{ __('Sector') }} *'
        });

        $('.tags').select2({
            placeholder: '+ {{ __('Tag') }} *'
        });

        $('#format_id').change(function (e) {
            var value = $(this).val() - 0;
            if (value) {
                $('.format').not('.format-' + value).hide();
                $('.format').not('.format-' + value).find('input, select').val('').prop('disabled', true);
                $('.format-' + value).show();
                $('.format-' + value).find('input, select').prop('disabled', false);
            } else {
                $('.format').hide();
                $('.format').find('input, select').prop('disabled', true);
            }
        }).trigger('change');

        $('input[name="external"]').change(function (e) {
            if (! $(this).is(':checked')) {
                return;
            }
            console.log($(this).closest('.format'));
            console.log($(this).val() - 0);

            var external = $(this).val() == 1;
            $(this).closest('.format').find('.link').toggle(external);
            $(this).closest('.format').find('.file').toggle(! external);
        }).trigger('change');

        // Image
        var myDropzone = new Dropzone('#dropzone', {
            acceptedFiles: @json(\App\MediaLibrary::IMAGE_ALLOWED),
            url: '{{ route('tool.image-upload') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            params: { id: '{{ uniqid() }}' },
            uploadMultiple: false,
            parallelUploads: 1,
            maxFiles: 1,
            maxFilesize: @json(\App\MediaLibrary::IMAGE_MAX_SIZE / 1000),
            addRemoveLinks: true,
            dictRemoveFile: '{{ __('Eliminar imagen') }}',
            dictFileTooBig: '{{ __('La imagen es mayor de :size MB', ['size' => \App\MediaLibrary::IMAGE_MAX_SIZE / 1000]) }}',
            timeout: 10000,
            thumbnailWidth: 200,
            thumbnailHeight: 200,
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

        // Fill image
        @if (old('image', ! empty($media->image)))
            var image = { name: '', size: ''};
            myDropzone.emit('addedfile', image);
            myDropzone.emit('thumbnail', image, '{{ old('image', (! empty($media->image) ? $media->imageUrl() : '')) }}');
            myDropzone.emit('complete', image);
            myDropzone.files.push(image);
        @endif

        // Gallery
        new Dropzone('#gallery', $.extend(true, {
            acceptedFiles: @json(\App\MediaLibrary::IMAGE_ALLOWED),
            url: '{{ route('tool.image-upload') }}',
            maxFiles: {{ \App\MediaLibrary::GALLERY_MAX_FILES }},
            maxFilesize: @json(\App\MediaLibrary::IMAGE_MAX_SIZE / 1000),
            init: function () {
                // Remove files if it is greater than 10
                // this.on('addedfile', function() {
                //     if (null != this.files[10]) {
                //         this.removeFile(this.files[10]);
                //     }
                // });

                // Fill gallery
                var files = @json(App\Tool::toDropzone(old('gallery', $files['gallery'])));
                for (i = 0; i < files.length; i++) {
                    this.emit('addedfile', files[i]);
                    // this.emit('thumbnail', files[i], files[i].url);
                    // this.createThumbnailFromUrl(files[i], files[i].url);
                    this.emit('success', files[i]);
                    this.emit('complete', files[i]);
                    this.files.push(files[i]);
                }
            },
            success: function (file, done) {
                var value = (done) ? done.path : file.name;
                this.emit('thumbnail', file, (done) ? done.thumbnail : file.thumbnail);
                $('#gallery .dz-preview:last-child').append('<input type="hidden" name="gallery[]" value="' + value + '">');
            },
            removedfile: function(file) {
                $('#gallery-input').append('<input type="hidden" name="gallery_remove[]" value="' + file.name + '">');
                file.previewElement.remove();
                // $('.dz-started').removeClass('dz-started');
            }
        }, dropzone_ops));

        $('#gallery').sortable({
            items:'.dz-preview',
            cursor: 'move',
            opacity: 0.5,
            containment: '#gallery',
            distance: 20,
            tolerance: 'pointer'
        });

        // Presentation
        new Dropzone('#presentation-dropzone', $.extend(true, {
            acceptedFiles: @json(\App\MediaLibrary::PRESENTATION_ALLOWED),
            url: '{{ route('tool.file_upload') }}',
            uploadMultiple: false,
            maxFiles: 1,
            maxFilesize: @json(\App\MediaLibrary::PRESENTATION_MAX_SIZE / 1000),
            init: function () {
                this.on('addedfile', function() {
                    if (null != this.files[1]) {
                        this.removeFile(this.files[0]);
                    }
                });

                // Fill
                var files = @json(App\Tool::toDropzone(old('presentation', $files['presentation'])));
                for (i = 0; i < files.length; i++) {
                    this.emit('addedfile', files[i]);
                    // this.emit('thumbnail', files[i], files[i].url);
                    // this.createThumbnailFromUrl(files[i], files[i].url);
                    this.emit('success', files[i]);
                    this.emit('complete', files[i]);
                    this.files.push(files[i]);
                }
            },
            success: function (file, done) {
                var value = (done) ? done.path : file.name;
                this.emit('thumbnail', file, (done) ? done.thumbnail : file.thumbnail);
                $('#presentation-dropzone .dz-preview:last-child').append('<input type="hidden" name="presentation[]" value="' + value + '">');
            },
            removedfile: function(file) {
                $('#presentation-input').append('<input type="hidden" name="presentation_remove[]" value="' + file.name + '">');
                file.previewElement.remove();
                // $('.dz-started').removeClass('dz-started');
            }
        }, dropzone_ops));

        // Document
        new Dropzone('#document-dropzone', $.extend(true, {
            acceptedFiles: @json(\App\MediaLibrary::DOCUMENT_ALLOWED),
            url: '{{ route('tool.file_upload') }}',
            uploadMultiple: false,
            maxFiles: 1,
            maxFilesize: @json(\App\MediaLibrary::DOCUMENT_MAX_SIZE / 10000),
            init: function () {
                var dz = this;
                this.on('addedfile', function(file) {
                    if (null != this.files[1]) {
                        this.removeFile(this.files[0]);
                    }
                });

                // Fill
                var files = @json(App\Tool::toDropzone(old('document', $files['document'])));
                for (i = 0; i < files.length; i++) {
                    this.emit('addedfile', files[i]);
                    // this.emit('thumbnail', files[i], files[i].url);
                    // this.createThumbnailFromUrl(files[i], files[i].url);
                    this.emit('success', files[i]);
                    this.emit('complete', files[i]);
                    this.files.push(files[i]);
                }
            },
            success: function (file, done) {
                var value = (done) ? done.path : file.name;
                this.emit('thumbnail', file, (done) ? done.thumbnail : file.thumbnail);
                $('#document-dropzone .dz-preview:last-child').append('<input type="hidden" name="document[]" value="' + value + '">');
            },
            removedfile: function(file) {
                $('#document-input').append('<input type="hidden" name="document_remove[]" value="' + file.name + '">');
                file.previewElement.remove();
                // $('.dz-started').removeClass('dz-started');
            }
        }, dropzone_ops));

        // Audio
        new Dropzone('#audio-dropzone', $.extend(true, {
            acceptedFiles: @json(\App\MediaLibrary::AUDIO_ALLOWED),
            url: '{{ route('tool.file_upload') }}',
            uploadMultiple: false,
            maxFiles: 1,
            maxFilesize: @json(\App\MediaLibrary::AUDIO_MAX_SIZE / 10000),
            init: function () {
                this.on('addedfile', function() {
                    if (null != this.files[1]) {
                        this.removeFile(this.files[0]);
                    }
                });

                // Fill
                var files = @json(App\Tool::toDropzone(old('audio', $files['audio'])));
                for (i = 0; i < files.length; i++) {
                    this.emit('addedfile', files[i]);
                    // this.emit('thumbnail', files[i], files[i].url);
                    // this.createThumbnailFromUrl(files[i], files[i].url);
                    this.emit('success', files[i]);
                    this.emit('complete', files[i]);
                    this.files.push(files[i]);
                }
            },
            success: function (file, done) {
                var value = (done) ? done.path : file.name;
                this.emit('thumbnail', file, (done) ? done.thumbnail : file.thumbnail);
                $('#audio-dropzone .dz-preview:last-child').append('<input type="hidden" name="audio[]" value="' + value + '">');
            },
            removedfile: function(file) {
                $('#audio-input').append('<input type="hidden" name="audio_remove[]" value="' + file.name + '">');
                file.previewElement.remove();
                // $('.dz-started').removeClass('dz-started');
            }
        }, dropzone_ops));

        $('#form').submit(function (e) {
            $(this).find('.date').each(function (index, elem) {
                if (! $(elem).val().length) {
                    return;
                }
                var value = $(elem).data('DateTimePicker').date().format('YYYY-MM-DD');
                $(elem).val(value);
            });
            loading();
        });
    });
</script>
@endsection
