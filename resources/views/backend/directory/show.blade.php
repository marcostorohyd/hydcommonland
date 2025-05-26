@extends('backend.layouts.app')

@section('title', __('Perfil'))

@section('content')

    {!! Form::model($directory) !!}
        <h2>{{ __('Usuario/a') }}</h2>
        <div class="row">
            <div class="col-12 form-group">
                {!! Form::email('user_email', $directory->user->email, ['class' => 'form-control', 'placeholder' => __('Email'), 'readonly']) !!}
            </div>
        </div>

        <h2>{{ __('Datos de contacto general') }}</h2>
        <div class="row">
            <div class="col-12 form-group">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Nombre'), 'readonly']) !!}
            </div>
            <div class="col-sm-8 form-group">
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('Email'), 'readonly']) !!}
            </div>
            <div class="col-sm-4 form-group">
                {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => __('Teléfono'), 'readonly']) !!}
            </div>
            <div class="col-12 form-group">
                {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => __('Dirección'), 'readonly']) !!}
            </div>
            <div class="col-sm-4 form-group">
                {!! Form::text('zipcode', null, ['class' => 'form-control', 'placeholder' => __('CP'), 'readonly']) !!}
            </div>
            <div class="col-sm-8 form-group">
                {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => __('Localidad'), 'readonly']) !!}
            </div>
            <div class="col-12 form-group">
                {!! Form::select('country_id', $data['countries'], null, ['class' => 'form-control', 'placeholder' => '+ ' . __('País'), 'disabled']) !!}
            </div>
            <div class="col-12 form-group">
                {!! Form::select('sectors[]', $data['sectors'], null, ['class' => 'form-control', 'id' => 'sector_id', 'disabled', 'multiple']) !!}
            </div>
            <div class="col-12 form-group">
                {!! Form::select('entity_id', $data['entities'], null, ['class' => 'form-control', 'placeholder' => '+ ' . __('Entidad'), 'disabled']) !!}
            </div>
            <div class="col-12 form-group mb-md-4">
                {!! Form::text('web', null, ['class' => 'form-control', 'placeholder' => __('Web'), 'readonly']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::text('facebook', null, ['class' => 'form-control', 'placeholder' => 'Facebook', 'readonly']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::text('twitter', null, ['class' => 'form-control', 'placeholder' => 'Twitter', 'readonly']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::text('instagram', null, ['class' => 'form-control', 'placeholder' => 'Instagram', 'readonly']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::text('linkedin', null, ['class' => 'form-control', 'placeholder' => 'Linkedin', 'readonly']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::text('tiktok', null, ['class' => 'form-control', 'placeholder' => 'TikTok', 'readonly']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::text('youtube', null, ['class' => 'form-control', 'placeholder' => 'YouTube', 'readonly']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::text('vimeo', null, ['class' => 'form-control', 'placeholder' => 'Vimeo', 'readonly']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::text('whatsapp', null, ['class' => 'form-control', 'placeholder' => 'WhatsApp', 'readonly']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::text('telegram', null, ['class' => 'form-control', 'placeholder' => 'Telegram', 'readonly']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::text('research_gate', null, ['class' => 'form-control', 'placeholder' => 'Research Gate', 'readonly']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::text('orcid', null, ['class' => 'form-control', 'placeholder' => 'ORCID', 'readonly']) !!}
            </div>
            <div class="col-md-6 form-group">
                {!! Form::text('academia_edu', null, ['class' => 'form-control', 'placeholder' => 'Academia.edu', 'readonly']) !!}
            </div>
        </div>

        <div id="person_contact" style="{{ 1 == $directory->entity_id ? 'display: none;' : '' }}">
            <h2>{{ __('Datos persona de contacto') }}</h2>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::text('contact_name', null, ['class' => 'form-control', 'placeholder' => __('Nombre'), 'readonly']) !!}
                </div>
                <div class="col-sm-8 form-group">
                    {!! Form::email('contact_email', null, ['class' => 'form-control', 'placeholder' => __('Email'), 'readonly']) !!}
                </div>
                <div class="col-sm-4 form-group">
                    {!! Form::text('contact_phone', null, ['class' => 'form-control', 'placeholder' => __('Teléfono'), 'readonly']) !!}
                </div>
            </div>
        </div>

        <div id="additional_info" style="{{ 1 == $directory->entity_id ? 'display: none;' : '' }}">
            <h2>{{ __('Información adicional') }}</h2>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::number('partners', null, ['class' => 'form-control', 'placeholder' => __('Nº de socios/as'), 'min' => 0, 'readonly']) !!}
                </div>
                <div class="col-12 form-group">
                    {!! Form::number('members', null, ['class' => 'form-control', 'placeholder' => __('Nº de comuneras/os'), 'min' => 0, 'readonly']) !!}
                </div>
                <div class="col-12 form-group">
                    {!! Form::number('represented', null, ['class' => 'form-control', 'placeholder' => __('Número de personas representadas'), 'min' => 0, 'readonly']) !!}
                </div>
                <div class="col-12 form-group">
                    {!! Form::number('surface', null, ['class' => 'form-control', 'placeholder' => __('Superficie'), 'min' => 0, 'readonly']) !!}
                </div>
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
                        {!! Form::textarea($lang . '[description]', old($lang . '.description', ! empty($directory) ? $directory->translate($lang)->description : ''), ['class' => 'form-control description', 'placeholder' => __('Escribe algo...')]) !!}
                    </div>
                @endforeach
            </div>
        </div>

        <h2>{{ __('Logotipo / fotografía') }}</h2>
        <div class="row">
            <div class="col-12 form-group">
                <div class="dropzone">
                    <div class="dz-preview">
                        <div class="dz-image">
                            <img src="{{ $directory->imageUrl() }}" alt="">
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

            $('#sector_id').select2({
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

            $('#form-destroy').on('submit', function (e) {
                return confirm('Se va a borrar de forma definitiva su cuenta. ¿Continuar?');
            });

        });

    </script>

@endsection
