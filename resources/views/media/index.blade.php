@extends('layouts.app')

@section('body_class', 'two-columns')

@section('content')
{!! Form::open(['route' => 'media.index', 'method' => 'post', 'id' => 'filter']) !!}
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-4 col-xl-3">
                <h1 class="mb-2 d-none d-lg-block">{{ __('Mediateca') }}</h1>
                <a href="#" class="title d-lg-none" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">{{ __('Filtro') }}</a>
                <div class="row d-none d-lg-flex">
                    <div class="col-12 mb-2">
                        <label for="">{{ __('País') }}</label>
                        {!! Form::select('country_id[]', $data['countries'], null, ['class' => 'form-control form-control-sm select2 emulate-select-invert' . ($errors->has('country_id') ? ' is-invalid' : ''), 'id' => 'countries', 'multiple', 'data-emulate' => '#collapseCountries']) !!}
                    </div>
                    <div class="col-12 mb-2">
                        <label for="">{{ __('Sector') }}</label>
                        {!! Form::select('sector_id[]', $data['sectors'], null, ['class' => 'form-control form-control-sm select2 emulate-select-invert' . ($errors->has('sector_id') ? ' is-invalid' : ''), 'id' => 'sectors', 'multiple', 'data-emulate' => '#collapseSectors']) !!}
                    </div>
                    <div class="col-12 mb-2">
                        <label for="">{{ __('Tag') }}</label>
                        {!! Form::select('tag_id[]', $data['tags'], null, ['class' => 'form-control form-control-sm select2 emulate-select-invert' . ($errors->has('tag_id') ? ' is-invalid' : ''), 'id' => 'tags', 'multiple', 'data-emulate' => '#collapseTags']) !!}
                    </div>
                </div>
                <div class="row d-lg-none collapse" id="collapseFilters">
                    <div class="col-12">
                        <a href="#" class="label" data-toggle="collapse" data-target="#collapseCountries" aria-expanded="false" aria-controls="collapseCountries">{{ __('País') }}</a>
                        <ul class="list-unstyled collapse emulate-select" id="collapseCountries">
                            @forelse ($data['countries'] as $value => $text)
                                <li><a href="#" data-value="{{ $value }}" data-select="#countries">{{ $text }}</a></li>
                            @empty
                                {{ __('No se han encontrado países') }}
                            @endforelse
                        </ul>
                    </div>
                    <div class="col-12">
                        <a href="#" class="label" data-toggle="collapse" data-target="#collapseSectors" aria-expanded="false" aria-controls="collapseSectors">{{ __('Sector') }}</a>
                        <ul class="list-unstyled collapse emulate-select" id="collapseSectors">
                            @forelse ($data['sectors'] as $value => $text)
                                <li><a href="#" data-value="{{ $value }}" data-select="#sectors">{{ $text }}</a></li>
                            @empty
                                <li>{{ __('No se han encontrado sectores') }}</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="col-12">
                        <a href="#" class="label" data-toggle="collapse" data-target="#collapseTags" aria-expanded="false" aria-controls="collapseTags">{{ __('Tag') }}</a>
                        <ul class="list-unstyled collapse emulate-select" id="collapseTags">
                            @forelse ($data['tags'] as $value => $text)
                                <li><a href="#" data-value="{{ $value }}" data-select="#tags">{{ $text }}</a></li>
                            @empty
                                <li>{{ __('No se han encontrado tags') }}</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8 col-xl-9">
                <div class="row mb-lg-4 d-lg-none">
                    <div class="col-12">
                        <h1 class="border-top pt-2">{{ __('Mediateca') }}</h1>
                    </div>
                </div>
                <div class="row subsection">
                    <div class="col-sm-6 col-lg-12">
                        <ul class="list-inline font-weight-bold mb-4">
                            <li class="list-inline-item">
                                {{ __('Inicio') }}:
                            </li>
                            @foreach ($data['formats'] as $item)
                                <li class="list-inline-item">
                                    <a class="btn-format" href="#" title="{{ $item->name }}" data-format="{{ $item->id }}">{{ $item->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="wrapper" style="height: 100%;">
                            {{-- @include('media.list') --}}
                            @include('media.group-list')
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-warning-light mb-0" role="alert">
                            <p>{!! __('Tu papel es clave: visibiliza tu trabajo, conoce el de otros y colabora. Si quieres compartir contenido audiovisual (vídeos, fotografías, presentaciones en power points, documentos de Word o audios) en la plataforma, utiliza nuestro :link1s formulario:link1e. Normalmente, será publicado en unos 5 días. ¡Gracias!', ['link1s' => '<a href="' . route('backend.media.create') . '">', 'link1e' => '</a>']) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::hidden('format_id', null, ['id' => 'format_id']) !!}
{!! Form::close() !!}
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha256-4hqlsNP9KM6+2eA8VUT0kk4RsMRTeS7QGHIM+MZ5sLY=" crossorigin="anonymous" />
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha256-NXRS8qVcmZ3dOv3LziwznUHPegFhPZ1F/4inU7uC8h0=" crossorigin="anonymous"></script>
<script>
    var url = '{{ route('media.list') }}';
    function filter(params) {
        $.post(url, params, function (res) {
            $('#wrapper').html(res);

            if (! params.format_id) {
                $('.carousel-format').slick({
                    arrows: true,
                    centerMode: false,
                    slidesToShow: 3,
                    infinite: false,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                adaptiveHeight: true,
                                slidesToShow: 1
                            }
                        }
                    ]
                });
            }
        });
    }

    $(function () {
        $('.carousel-format').slick({
            arrows: true,
            centerMode: false,
            slidesToShow: 3,
            infinite: false,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        adaptiveHeight: true,
                        slidesToShow: 1
                    }
                }
            ]
        });

        $('.btn-format').click(function (e) {
            e.preventDefault();
            $('#format_id').val($(this).data('format'));
            filter($(this).closest('form').serialize());
            return false;
        });

        $('#filter select').change(function (e) {
            filter($(this).closest('form').serialize());
        });

        $('.emulate-select a').click(function (e) {
            e.preventDefault();

            var select = $(this).data('select');
            var value = $(this).data('value');

            $(this).toggleClass('selected');

            $(select + ' option[value="' + value + '"]').prop('selected', $(this).hasClass('selected')).change();
        });

        $('.emulate-select-invert').change(function (e) {
            var select = $(this).data('emulate');
            var value = $(this).val();

            $(select + ' a').each(function (index, elem) {
                $(elem).toggleClass('selected', (-1 !== $.inArray($(elem).data('value'), value.map(Number))));
            });
        });

        setInterval(function () {
            $('#wrapper .page-link').unbind();
            $('#wrapper .page-link').click(function (e) {
                e.preventDefault();
                e.stopPropagation();

                var page = getUrlParameter('page', $(this).attr('href'));
                filter($('#filter').closest('form').serialize() + '&page=' + page);

                return false;
            });
        }, 500);
    });
</script>
@endsection
