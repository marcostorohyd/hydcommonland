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
        <div class="col-12 col-sm-6 form-group">
            @if (in_array($media->status_id, [\App\Status::PENDING, \App\Status::REFUSED]))
                <a href="{{ route('backend.media.approve', $media->id) }}" class="btn btn-dark btn-lg mr-3" type="submit">{{ __('Aprobar') }}</a>
            @endif
            @if (in_array($media->status_id, [\App\Status::PENDING, \App\Status::APPROVED]))
                <a href="{{ route('backend.media.refuse', $media->id) }}" class="btn btn-dark btn-lg" type="submit">{{ __('Rechazar') }}</a>
            @endif
        </div>
        @if (\App\Status::APPROVED == $media->status_id)
            <div class="col-12 col-sm-6 form-group text-sm-right">
                <a href="{{ route('media.show', $media->id) }}" class="btn btn-dark btn-lg" type="submit">{{ __('Ver') }}</a>
            </div>
        @endif
    </div>
@endif

<h2>{{ __('Datos de la mediateca') }}</h2>
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
        <div class="input-group">
            {!! Form::select('sectors[]', $data['sectors'], null, ['class' => 'form-control' . ($errors->has('sectors') ? ' is-invalid' : ''), 'id' => 'sectors', 'required', 'multiple']) !!}
            <div class="input-group-append select-all">
                <img src="{{ asset('svg/icons/all.svg') }}" width="30" height="30">
            </div>
        </div>
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

<h2 class="format format-1 format-3 format-4 format-5">{{ __('Foto de portada') }} <small>({{ \App\Media::humanize(\App\MediaLibrary::IMAGE_ALLOWED) }} {{ __('tamaño máx. :size MB.', ['size' => \App\MediaLibrary::IMAGE_MAX_SIZE / 1000]) }})</small></h2>
<div class="row format format-1 format-3 format-4 format-5">
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

<h2 class="format format-1">{{ __('Vídeo') }}*</h2>
<h2 class="format format-2">{{ __('Galería de fotos') }}* <small>({{ \App\Media::humanize(\App\MediaLibrary::IMAGE_ALLOWED) }} {{ __('tamaño máx. por imagen :size MB.', ['size' => \App\MediaLibrary::IMAGE_MAX_SIZE / 1000]) }})</small></h2>
<h2 class="format format-3">{{ __('Presentación power point') }}* <small>({{ \App\Media::humanize(\App\MediaLibrary::PRESENTATION_ALLOWED) }} {{ __('tamaño máx. :size MB.', ['size' => \App\MediaLibrary::PRESENTATION_MAX_SIZE / 1000]) }})</small></h2>
<h2 class="format format-4">{{ __('Documentos') }}* <small>({{ \App\Media::humanize(\App\MediaLibrary::DOCUMENT_ALLOWED) }} {{ __('tamaño máx. :size MB.', ['size' => \App\MediaLibrary::DOCUMENT_MAX_SIZE / 1000]) }})</small></h2>
<h2 class="format format-5">{{ __('Audios') }}* <small>({{ \App\Media::humanize(\App\MediaLibrary::AUDIO_ALLOWED) }} {{ __('tamaño máx. :size MB.', ['size' => \App\MediaLibrary::AUDIO_MAX_SIZE / 1000]) }})</small></h2>

<div class="row block">
    <div class="col-12 form-group format format-3 format-4 format-5">
        <div class="form-control-plaintext">
            <div class="row">
                <div class="col-auto pl-1 pr-4">
                    <label class="form-control-lg" for="">{{ __('Elije entre') }}</label>
                </div>
                <div class="col-auto px-4">
                    <div class="custom-control custom-radio custom-radio-to-checkbox">
                        {!! Form::radio('external', 0, null, ['class' => 'custom-control-input' . ($errors->has('external') ? ' is-invalid' : ''), 'id' => 'external_0']) !!}
                        <label class="custom-control-label" for="external_0">
                            {{ __('Subir un archivo') }}
                        </label>
                    </div>
                </div>
                <div class="col-auto px-4">
                    <div class="custom-control custom-radio custom-radio-to-checkbox">
                        {!! Form::radio('external', 1, null, ['class' => 'custom-control-input' . ($errors->has('external') ? ' is-invalid' : ''), 'id' => 'external_1']) !!}
                        <label class="custom-control-label" for="external_1">
                            {{ __('Enlace externo') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 form-group link format format-1 format-3 format-4 format-5">
        {!! Form::url('link', null, ['class' => 'form-control' . ($errors->has('link') ? ' is-invalid' : ''), 'data-placeholder_format_default' => __('Enlace'), 'data-placeholder_format_1' => __('Vimeo / YouTube / Otra web (enlace)')]) !!}
    </div>

    {{-- Gallery --}}
    <div class="col-12 form-group format format-2">
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

    {{-- Presentation --}}
    <div class="col-12 form-group file format format-3">
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

    {{-- Document --}}
    <div class="col-12 form-group file format format-4">
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

    {{-- Audio --}}
    <div class="col-12 form-group file format format-5">
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

    <div class="col-12 form-group format format-1 format-4 format-5">
        {!! Form::number('length', null, ['class' => 'form-control' . ($errors->has('length') ? ' is-invalid' : ''), 'data-placeholder_format_default' => __('Duración (en minutos)'), 'data-placeholder_format_4' => __('Número de páginas'), 'min' => 0, 'max' => 99999]) !!}
    </div>

    <div class="col-12 form-group format format-1 format-2 format-3 format-4 format-5">
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

    function checkExternal() {
        var external = 0;
        var flag = false;
        $('input[name="external"]').each(function (index, elem) {
            if ($(elem).is(':checked')) {
                external = 1 == $(elem).val();
                flag = true;
            }
        });

        var format_id = $('#format_id').val();
        if (! flag) {
            $('.format-' + format_id + '.link').hide();
            $('.format-' + format_id + '.file').hide();
            return;
        }

        $('.format-' + format_id + '.link').toggle(external);
        $('.format-' + format_id + '.file').toggle(! external);
    }

    $(function() {
        $('#sectors').select2({
            placeholder: '+ {{ __('Sector') }}*'
        });

        $('.tags').select2({
            placeholder: '+ {{ __('Tag') }}'
        });

        $('input[name="external"]').click(checkExternal);

        $('#format_id').change(function (e) {
            var value = $(this).val() - 0;
            if (value) {
                $('.format').not('.format-' + value).hide();
                $('.format-' + value).show();
            } else {
                $('.format').hide();
            }

            $('[data-placeholder_format_default]').each(function (index, elem) {
                var placeholder = $(elem).data('placeholder_format_default');
                $(elem).attr('placeholder', placeholder);
            });
            var format_id = $('#format_id').val();
            $('[data-placeholder_format_' + format_id + ']').each(function (index, elem) {
                var placeholder = $(elem).data('placeholder_format_' + format_id);
                $(elem).attr('placeholder', placeholder);
            });

            if (value != 1 && value != 2) {
                checkExternal();
            }
        }).trigger('change');

        // Image
        new Dropzone('#dropzone', $.extend(true, {}, dropzone_ops, {
            acceptedFiles: @json(\App\MediaLibrary::IMAGE_ALLOWED),
            url: '{{ route('tool.image-upload') }}',
            maxFiles: 1,
            maxFilesize: @json(\App\MediaLibrary::IMAGE_MAX_SIZE / 1000),
            thumbnailWidth: 1200,
            thumbnailHeight: 250,
            init: function () {
                this.on('addedfile', function() {
                    if (null != this.files[1]) {
                        this.removeFile(this.files[0]);
                    }
                });

                // Fill
                @if (old('image', ! empty($media->image)))
                    var image = { name: '', size: ''};
                    this.emit('addedfile', image);
                    this.emit('thumbnail', image, '{{ old('image', (! empty($media->image) ? $media->imageUrl() : '')) }}');
                    this.emit('complete', image);
                    this.files.push(image);
                @endif
            },
            success: function (file, done) {
                $('#image').val(done.path);
                $('#image_is_new').val(1);
            },
            removedfile: function(file) {
                $('#image').val('');
                $('#image_is_new').val('');
                file.previewElement.remove();
                // $('.dz-started').removeClass('dz-started');
            }
        }));

        // Gallery
        new Dropzone('#gallery', $.extend(true, {}, dropzone_ops, {
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
                this.emit('thumbnail', file, (done) ? done.path : file.thumbnail);
                $('#gallery .dz-preview:last-child').append('<input type="hidden" name="gallery[]" value="' + value + '">');
            },
            removedfile: function(file) {
                $('#gallery-input').append('<input type="hidden" name="gallery_remove[]" value="' + file.name + '">');
                file.previewElement.remove();
                // $('.dz-started').removeClass('dz-started');
            }
        }));

        $('#gallery').sortable({
            items:'.dz-preview',
            cursor: 'move',
            opacity: 0.5,
            containment: '#gallery',
            distance: 20,
            tolerance: 'pointer'
        });

        // Presentation
        new Dropzone('#presentation-dropzone', $.extend(true, {}, dropzone_ops, {
            acceptedFiles: @json(\App\MediaLibrary::PRESENTATION_ALLOWED),
            url: '{{ route('tool.file_upload') }}',
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
        }));

        // Document
        new Dropzone('#document-dropzone', $.extend(true, {}, dropzone_ops, {
            acceptedFiles: @json(\App\MediaLibrary::DOCUMENT_ALLOWED),
            url: '{{ route('tool.file_upload') }}',
            maxFiles: 1,
            maxFilesize: @json(\App\MediaLibrary::DOCUMENT_MAX_SIZE / 1000),
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
        }));

        // Audio
        new Dropzone('#audio-dropzone', $.extend(true, {}, dropzone_ops, {
            acceptedFiles: @json(\App\MediaLibrary::AUDIO_ALLOWED),
            url: '{{ route('tool.file_upload') }}',
            maxFiles: 1,
            maxFilesize: @json(\App\MediaLibrary::AUDIO_MAX_SIZE / 1000),
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
        }));

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
