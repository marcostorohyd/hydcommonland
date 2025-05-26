@extends('layouts.app')

@section('body_class', 'two-columns')

@section('content')
{!! Form::open(['route' => 'news.index', 'method' => 'post', 'id' => 'filter']) !!}
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-4 col-xl-3">
                <h1 class="mb-2 d-none d-lg-block">{{ __('Noticias') }}</h1>
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
                </div>
            </div>
            <div class="col-12 col-lg-8 col-xl-9">
                <div class="row mb-lg-4 d-lg-none">
                    <div class="col-12">
                        <h1 class="border-top pt-2">{{ __('Noticias') }}</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="wrapper" style="height: 100%;">
                            @include('news.list')
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-danger mb-0" role="alert">
                            <p>{!! __('Tu papel es clave: visibiliza tu trabajo, conoce el de otros y colabora. Si quieres compartir una noticia en la plataforma, utiliza nuestro :link1s formulario :link1e. Normalmente, la noticia será publicada en unos 5 días. Recuerda que necesitas :link2s registrarte :link2e en el directorio de la plataforma para poder compartir noticias.', ['link1s' => '<a href="' . route('backend.news.create') . '">', 'link1e' => '</a>', 'link2s' => '<a href="' . route('register') . '">', 'link2e' => '</a>']) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}
@endsection

@section('js')
<script>
    var url = '{{ route('news.list') }}';
    function filter(params) {
        $.post(url, params, function (res) {
            $('#wrapper').html(res);
        });
    }

    $(function () {
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
