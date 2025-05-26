@extends('backend.layouts.app')

@section('title', __('Acerca de'))

@section('content')

    {!! Form::open(['route' => ['backend.about.update'], 'method' => 'PUT']) !!}
        <h2>{{ __('Descripción') }}</h2>
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
                        {!! Form::textarea('about[' . $lang . ']', old('about.' . $lang, $about["about_{$lang}"] ?? ''), ['class' => 'form-control description' . ($errors->has('about.' . $lang) ? ' is-invalid' : ''), 'placeholder' => __('Escribe algo...')]) !!}
                    </div>
                @endforeach
            </div>
        </div>

        <h2>{{ __('Folleto') }} <small>({{ \App\Media::humanize(\App\User::IMAGE_ALLOWED) }} {{ __('tamaño máx. :size MB.', ['size' => \App\User::IMAGE_MAX_SIZE / 1000]) }})</small></h2>
        <div class="row">
            <div class="col-12 form-group">
                <div id="leaflet" class="dropzone {{ $errors->has('leaflet_image') ? ' is-invalid' : '' }}">
                    <div class="dz-default dz-message">
                        <span>
                            <em class="fa fa-upload text-muted"></em>
                            <br>{{ __('Arrastra el archivo aquí para subirlo') }}
                        </span>
                    </div>
                    <div class="fallback">
                        {!! Form::file('file', ['class' => 'form-control' . ($errors->has('about_leaflet_image') ? ' is-invalid' : ''), 'accept' => \App\User::IMAGE_ALLOWED]) !!}
                    </div>
                </div>
                {!! Form::hidden('about_leaflet_image', old('about_leaflet_image', $about['about_leaflet_image'] ?? ''), ['id' => 'about_leaflet_image']) !!}
                {!! Form::hidden('about_leaflet_image_is_new', null, ['id' => 'about_leaflet_image_is_new']) !!}
            </div>
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
                        {!! Form::text($lang . '[about_leaflet_link]', old($lang . '.about_leaflet_link', $about["about_leaflet_link_{$lang}"] ?? ''), ['class' => 'form-control about_leaflet_link' . ($errors->has($lang . '.about_leaflet_link') ? ' is-invalid' : ''), 'placeholder' => __('Enlace')]) !!}
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <button class="btn btn-dark btn-lg" type="submit">{{ __('Guardar/Actualizar') }}</button>
            </div>
        </div>
    {!! Form::close() !!}

@endsection

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

            $('.description').summernote({
                height: ((992 >= $(window).width()) ? '250px' : '350px'),
                lang: '{{ locale() }}',
                theme: 'default',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline']],
                    ['insert', ['link']],
                ],
                styleTags: ['h2', 'h3', 'p'],
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
            });

            var myDropzone = new Dropzone('#leaflet', {
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
                    $('#about_leaflet_image').val(done.path);
                    $('#about_leaflet_image_is_new').val(1);
                },
                error: function (file, res) {
                    $(file.previewElement).addClass('dz-error').find('.dz-error-message').text(res.error);
                },
                removedfile: function(file) {
                    $('#about_leaflet_image').val('');
                    $('#about_leaflet_image_is_new').val('');
                    file.previewElement.remove();
                    // $('.dz-started').removeClass('dz-started');
                }
            });

            // Fill image
            @if ($image = old('about_leaflet_image', ! empty($about['about_leaflet_image'])))
                var image = { name: '', size: ''};
                myDropzone.emit('addedfile', image);
                myDropzone.emit('thumbnail', image, '{{ old('about_leaflet_image', (! empty($about['about_leaflet_image']) ? \App\Config::aboutLeafletImageUrl($about['about_leaflet_image']) : '')) }}');
                myDropzone.emit('complete', image);
                myDropzone.files.push(image);
            @endif

        });

    </script>

@endsection
