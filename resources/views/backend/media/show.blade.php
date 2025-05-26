@extends('backend.layouts.app')

@section('title', __('Mediateca'))

@section('content')
{!! Form::model($media) !!}
    <div class="row mb-4">
        <div class="col-12">
            @switch($media->status_id)
                @case(\App\Status::APPROVED)
                    @break

                @case(\App\Status::REFUSED)
                    <div role="alert" class="alert alert-danger fade show">
                        <span class="sr-only">danger:</span>
                        {{ __('Esta mediateca ha sido rechazado') }}
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

    <h2>{{ __('Datos de la mediateca') }}</h2>
    <div class="row">
        <div class="col-12 form-group">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Título'), 'readonly']) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::text('date', $media->date->format('Y-m-d'), ['class' => 'form-control date', 'placeholder' => __('Fecha'), 'readonly']) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::select('country_id', $data['countries'], null, ['class' => 'form-control', 'placeholder' => '+ ' . __('País'), 'disabled']) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::select('sectors[]', $data['sectors'], null, ['class' => 'form-control', 'id' => 'sectors', 'disabled', 'multiple']) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::text('author', null, ['class' => 'form-control', 'placeholder' => __('Autor'), 'readonly']) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('Contacto (email)'), 'readonly']) !!}
        </div>
        <div class="col-12 form-group">
            {!! Form::select('format_id', $data['formats'], null, ['class' => 'form-control', 'id' => 'format_id', 'placeholder' => '+ ' . __('Formato'), 'readonly']) !!}
        </div>
    </div>

    <h2>{{ __('Foto de portada') }}</h2>
    <div class="row">
        <div class="col-12 form-group">
            <div class="dropzone">
                <div class="dz-preview">
                    <div class="dz-image">
                        <img src="{{ $media->imageUrl() }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2 class="format format-1">{{ __('Vídeo') }}</h2>
    <h2 class="format format-2">{{ __('Galería de fotos') }}</h2>
    <h2 class="format format-3">{{ __('Presentación power point') }}</h2>
    <h2 class="format format-4">{{ __('Documentos') }}</h2>
    <h2 class="format format-5">{{ __('Audios') }}</h2>

    <div class="row block">
        <div class="col-12 form-group format format-3 format-4 format-5">
            <div class="form-control-plaintext">
                <div class="row">
                    <div class="col-auto pl-1 pr-4">
                        <label class="form-control-lg" for="">{{ __('Elije entre') }}</label>
                    </div>
                    <div class="col-auto px-4">
                        <div class="custom-control custom-radio custom-radio-to-checkbox">
                            {!! Form::radio('external', 0, null, ['class' => 'custom-control-input', 'id' => 'external_0', 'disabled']) !!}
                            <label class="custom-control-label" for="external_0">
                                {{ __('Subir un archivo') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-auto px-4">
                        <div class="custom-control custom-radio custom-radio-to-checkbox">
                            {!! Form::radio('external', 1, null, ['class' => 'custom-control-input', 'id' => 'external_1', 'disabled']) !!}
                            <label class="custom-control-label" for="external_1">
                                {{ __('Enlace externo') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 form-group link format format-1 format-3 format-4 format-5">
            {!! Form::url('link', null, ['class' => 'form-control' . ($errors->has('link') ? ' is-invalid' : ''), 'data-placeholder_format_default' => __('Enlace'), 'data-placeholder_format_1' => __('Vimeo / YouTube / Otra web (enlace)'), 'readonly']) !!}
        </div>

        @switch($media->format_id)
            @case(\App\Format::GALLERY)
                <div class="col-12 form-group format format-2">
                    <div class="dropzone dropzone-gallery">
                        <div class="dz-preview">
                            @foreach ($media->getMedia('gallery') as $item)
                                <div class="dz-image">
                                    <img class="img-fluid" src="{{ $item->getUrl() }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @break

            @case(\App\Format::PRESENTATION)
            @case(\App\Format::DOCUMENT)
            @case(\App\Format::AUDIO)
                <div class="col-12 form-group file format format-{{ $media->format_id }}">
                    <div class="dropzone dropzone-file">
                        <div class="dz-preview">
                            @foreach ($media->getMedia($media->format->media_collection) as $item)
                                <div class="dz-image">
                                    <img class="img-fluid" src="{{ \App\Tool::mimeToUrl($item->getUrl(), $item->mime_type) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @break

            @default

        @endswitch

        <div class="col-12 form-group format format-1 format-4 format-5">
            {!! Form::number('length', null, ['class' => 'form-control' . ($errors->has('length') ? ' is-invalid' : ''), 'data-placeholder_format_default' => __('Duración (en minutos)'), 'data-placeholder_format_4' => __('Número de páginas'), 'readonly']) !!}
        </div>

        <div class="col-12 form-group">
            {!! Form::select('tags[]', $data['tags'], null, ['class' => 'form-control tags', 'multiple', 'disabled']) !!}
        </div>
    </div>
{!! Form::close() !!}
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" integrity="sha256-e47xOkXs1JXFbjjpoRr1/LhVcqSzRmGmPqsrUQeVs+g=" crossorigin="anonymous" />
@endsection

@section('js')
<script>
    $(function() {
        $('#sectors').select2({
            placeholder: '+ {{ __('Sector') }}'
        });

        $('.tags').select2({
            placeholder: '+ {{ __('Tag') }}'
        });

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
        }).trigger('change');

        var external = {{ $media->external }} == 1;
        var format_id = $('#format_id').val();
        $(this).closest('.block').find('.format-' + format_id + '.link').toggle(external);
        $(this).closest('.block').find('.format-' + format_id + '.file').toggle(! external);
    });
</script>

@endsection
