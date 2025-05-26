@extends('backend.layouts.app')

@section('title', __('Noticias'))

@section('content')
{!! Form::model($news) !!}
    <div class="row mb-4">
        <div class="col-12">
            @switch($news->status_id)
                @case(\App\Status::APPROVED)
                    @break

                @case(\App\Status::REFUSED)
                    <div role="alert" class="alert alert-danger fade show">
                        <span class="sr-only">danger:</span>
                        {{ __('Esta noticia ha sido rechazado') }}
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

    <h2>{{ __('Datos de la noticia') }}</h2>
    <div class="row">
        <div class="col-12 form-group">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Nombre del noticia'), 'readonly']) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::text('date', $news->date->format('d/m/Y'), ['class' => 'form-control date-readonly', 'placeholder' => __('Fecha'), 'readonly']) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::select('country_id', $data['countries'], null, ['class' => 'form-control', 'placeholder' => '+ ' . __('País'), 'disabled']) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::select('sectors[]', $data['sectors'], null, ['class' => 'form-control', 'id' => 'sectors', 'multiple', 'disabled']) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('Contacto (email)'), 'readonly']) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::url('link', null, ['class' => 'form-control', 'placeholder' => __('Enlace'), 'readonly']) !!}
        </div>
    </div>

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
                    {!! Form::textarea($lang . '[description]', old($lang . '.description', ! empty($news) ? $news->translate($lang)->description : ''), ['class' => 'form-control description' . ($errors->has($lang . '.description') ? ' is-invalid' : ''), 'placeholder' => __('Escribe algo...')]) !!}
                </div>
            @endforeach
        </div>
    </div>

    <h2>{{ __('Foto de portada') }}</h2>
    <div class="row">
        <div class="col-12">
            <div class="dropzone">
                <div class="dz-preview">
                    <div class="dz-image">
                        <img src="{{ $news->imageUrl() }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" integrity="sha256-ADCoAb8+4Q0aUjknVls52/iuqleXITKP65owZtLSGBI=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" integrity="sha256-e47xOkXs1JXFbjjpoRr1/LhVcqSzRmGmPqsrUQeVs+g=" crossorigin="anonymous" />
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.min.js" integrity="sha256-EqzdHRQ0S25bXoh1W7841pzdUUgmlUk90Ov1Ckj1nk4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/lang/summernote-es-ES.min.js" integrity="sha256-lSdhACt5P3B9W+uMy6BRXP3YJaY1poz40DlTQaTnAko=" crossorigin="anonymous"></script>
<script>
    $(function() {
        $('#sectors').select2({
            placeholder: '+ {{ __('Sector') }}'
        });

        $('.description').summernote(
            $.extend(true, {
                height: ((992 >= $(window).width()) ? '250px' : '350px'),
                callbacks: {
                    onInit: function() {
                        $('.description').parent().find('.note-editable').attr('contenteditable', false);
                        $('.description').parent().find('.btn').prop('disabled', true);
                    }
                }
            }, summernote_ops)
        );
        $('.description').summernote('disable');
    });
</script>

@endsection
