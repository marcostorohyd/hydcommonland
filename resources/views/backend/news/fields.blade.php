@if (! empty($news))
    <div class="row mb-4">
        <div class="col-12">
            @switch($news->status_id)
                @case(\App\Status::APPROVED)
                    <div role="alert" class="alert alert-success fade show">
                        <span class="sr-only">success:</span>
                        {{ __('Esta noticia ha sido aprobada') }}
                    </div>

                    @break

                @case(\App\Status::REFUSED)
                    <div role="alert" class="alert alert-danger fade show">
                        <span class="sr-only">danger:</span>
                        {{ __('Esta noticia ha sido rechazada') }}
                    </div>

                    @break

                @default
                    <div role="alert" class="alert alert-info fade show">
                        <span class="sr-only">warning:</span>
                        {{ __('Esta noticia está pendiente de aprobación') }}
                    </div>

            @endswitch
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 form-group">
            @if (in_array($news->status_id, [\App\Status::PENDING, \App\Status::REFUSED]))
                <a href="{{ route('backend.news.approve', $news->id) }}" class="btn btn-dark btn-lg mr-3" type="submit">{{ __('Aprobar') }}</a>
            @endif
            @if (in_array($news->status_id, [\App\Status::PENDING, \App\Status::APPROVED]))
                <a href="{{ route('backend.news.refuse', $news->id) }}" class="btn btn-dark btn-lg" type="submit">{{ __('Rechazar') }}</a>
            @endif
        </div>
        @if (\App\Status::APPROVED == $news->status_id)
            <div class="col-12 col-sm-6 form-group text-sm-right">
                <a href="{{ route('news.show', $news->id) }}" class="btn btn-dark btn-lg" type="submit">{{ __('Ver') }}</a>
            </div>
        @endif
    </div>
@endif

<h2>{{ __('Datos de la noticia') }}</h2>
<div class="row">
    <div class="col-12 form-group">
        {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('Título de la noticia') . '*', 'required']) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::text('date', old('date', ! empty($news->date) ? $news->date->format('Y-m-d') : ''), ['class' => 'form-control date' . ($errors->has('date') ? ' is-invalid' : ''), 'placeholder' => __('Fecha') . '*', 'required']) !!}
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
        {!! Form::email('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => __('Contacto (email)') . '*', 'required']) !!}
    </div>
    <div class="col-12 form-group">
        {!! Form::url('link', null, ['class' => 'form-control' . ($errors->has('link') ? ' is-invalid' : ''), 'placeholder' => __('Enlace')]) !!}
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
                {!! Form::textarea($lang . '[description]', old($lang . '.description', ! empty($news) ? $news->translate($lang)->description : ''), ['class' => 'form-control description' . ($errors->has($lang . '.description') ? ' is-invalid' : ''), 'placeholder' => __('Escribe algo...')]) !!}
            </div>
        @endforeach
    </div>
</div>

<h2>{{ __('Foto de portada') }}* <small>({{ \App\Media::humanize(\App\News::IMAGE_ALLOWED) }} {{ __('tamaño máx. :size MB.', ['size' => \App\News::IMAGE_MAX_SIZE / 1000]) }})</small></h2>
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
                {!! Form::file('file', ['class' => 'form-control' . ($errors->has('image') ? ' is-invalid' : ''), 'accept' => \App\News::IMAGE_ALLOWED]) !!}
            </div>
        </div>
        {!! Form::hidden('image', null, ['id' => 'image']) !!}
        {!! Form::hidden('image_is_new', null, ['id' => 'image_is_new']) !!}
        <p>* {{ __('Campos requeridos') }}</p>
    </div>
</div>

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
        $('#sectors').select2({
            placeholder: '+ {{ __('Sector') }}*'
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
            acceptedFiles: @json(\App\News::IMAGE_ALLOWED),
            url: '{{ route('tool.image-upload') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            params: { id: '{{ uniqid() }}' },
            uploadMultiple: false,
            parallelUploads: 1,
            maxFiles: 1,
            maxFilesize: @json(\App\News::IMAGE_MAX_SIZE / 1000),
            addRemoveLinks: true,
            dictRemoveFile: '{{ __('Eliminar imagen') }}',
            dictFileTooBig: '{{ __('La imagen es mayor de :size MB', ['size' => \App\News::IMAGE_MAX_SIZE / 1000]) }}',
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

        // Fill image
        @if ($image = old('image', ! empty($news->image)))
            var image = { name: '', size: ''};
            myDropzone.emit('addedfile', image);
            myDropzone.emit('thumbnail', image, '{{ old('image', (! empty($news->image) ? $news->imageUrl() : '')) }}');
            myDropzone.emit('complete', image);
            myDropzone.files.push(image);
        @endif

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
