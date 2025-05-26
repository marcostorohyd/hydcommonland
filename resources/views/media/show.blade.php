@extends('layouts.app')

@section('body_class', 'two-columns-space')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="row navigation-float-pre">
                <div class="col-12">
                    <div class="text-uppercase mb-2">{{ $media->date->format('d M Y') }}</div>
                    <h1>{{ $media->name }}</h1>
                    <div class="row mx-0">
                        <div class="col-12">
                            <dl class="row">
                                @if (! empty($media->country_id))
                                    <dt class="col-4 pl-0">{{ __('País') }}</dt>
                                    <dd class="col-8">{{ $media->country->name }}</dd>
                                @endif
                                @if (! empty($media->author))
                                    <dt class="col-4 pl-0">{{ __('Autor') }}</dt>
                                    <dd class="col-8">{{ $media->author }}</dd>
                                @endif
                                <dt class="col-4 pl-0">{{ __('Contacto') }}</dt>
                                <dd class="col-8"><a href="mailto:{{ $media->email }}" target="_blank">{{ $media->email }}</a></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            @if ($media->isDownloadable())
                <div class="navigation navigation-float d-none d-xl-block">
                    <input type="image" class="btn btn-xl download btn-download" title="{{ __('Descargar') }}" src="{{ url('svg/icons/download.svg') }}" value="{{ __('Descargar') }}">
                </div>
            @endif
        </div>
        <div class="col-12 col-sm mb-5 mb-xl-0 pt-xl-2 position-relative">
            @switch($media->format_id)
                @case(\App\Format::VIDEO)
                    <div class="wrapper-player">
                        @if (empty($data['provider']))
                            <div class="player-preview">
                                @if ($media->image)
                                    <a href="{{ $media->link }}" class="d-block" target="_blank">
                                        <img class="img-fluid img-fit" src="{{ $media->imageUrl() }}" alt="">
                                    </a>
                                @else
                                    <a href="{{ $media->link }}" class="d-block" target="_blank">
                                        <div class="media-img" style="background-color: #{{ $media->format->color }};"></div>
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="player-preview player-preview-container">
                                @if ($media->image)
                                    <img class="img-fluid img-fit" src="{{ $media->imageUrl() }}" alt="">
                                @else
                                    <div class="media-img" style="background-color: #{{ $media->format->color }};"></div>
                                @endif
                            </div>
                            <div id="player" class="player" data-plyr-provider="{{ $data['provider'] }}" data-plyr-embed-id="{{ $data['id'] }}" poster="{{ $media->imageUrl() }}"></div>
                        @endif
                    </div>
                    @break
                @case(\App\Format::GALLERY)
                    @php $gallery = $media->getMedia('gallery') @endphp
                    @if (1 < $gallery->count())
                        <div class="media-gallery">
                            <div id="carouselControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($gallery as $item)
                                        <div class="carousel-item {{ $loop->index ? '' : 'active' }}">
                                            <img class="img-fluid img-fit img-fit" src="{{ $item->getUrl() }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselControls" role="button"
                                    data-slide="prev">
                                    <span class="fa fa-chevron-left fa-2x" aria-hidden="true"></span>
                                    <span class="sr-only">{{ __('Anterior') }}</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselControls" role="button"
                                    data-slide="next">
                                    <span class="fa fa-chevron-right fa-2x" aria-hidden="true"></span>
                                    <span class="sr-only">{{ __('Siguiente') }}</span>
                                </a>
                            </div>
                        </div>
                    @elseif ($gallery->count())
                        <img class="img-fluid img-fit" src="{{ $gallery[0]->getUrl() }}" alt="">
                    @else
                        <div class="media-img" style="background-color: #{{ $media->format->color }};"></div>
                    @endif
                    @break
                @case(\App\Format::PRESENTATION)
                @case(\App\Format::DOCUMENT)
                    @if ($media->hasViewerCompatibility())
                        {{-- <object data="{{ $media->viewerUrl() }}" type="application/pdf" class="w-100" height="800">
                            <iframe src="https://docs.google.com/gview?url={{ $media->viewerUrl() }}&embedded=true" class="w-100" height="800"></iframe>
                        </object> --}}
                        <iframe src="https://docs.google.com/gview?url={{ $media->viewerUrl() }}&embedded=true" class="w-100" height="800"></iframe>
                    @elseif ($media->image)
                        <img class="img-fluid img-fit" src="{{ $media->imageUrl() }}" alt="">
                    @else
                        <div class="media-img" style="background-color: #{{ $media->format->color }};"></div>
                    @endif
                    @break
                @case(\App\Format::AUDIO)
                    @if ($media->hasViewerCompatibility())
                        <div class="wrapper-player">
                            <div class="player-preview player-preview-container">
                                @if ($media->image)
                                    <img class="img-fluid img-fit" src="{{ $media->imageUrl() }}" alt="">
                                @else
                                    <div class="media-img" style="background-color: #{{ $media->format->color }};"></div>
                                @endif
                            </div>
                            <audio id="player" class="player" controls>
                                <source src="{{ $media->viewerUrl() }}" type="audio/mp3" poster="{{ $media->imageUrl() }}" />
                            </audio>
                        </div>
                    @elseif ($media->image)
                        <img class="img-fluid img-fit" src="{{ $media->imageUrl() }}" alt="">
                    @else
                        <div class="media-img" style="background-color: #{{ $media->format->color }};"></div>
                    @endif
                    @break
                @default
                    @if ($media->image)
                        <img class="img-fluid img-fit" src="{{ $media->imageUrl() }}" alt="">
                    @else
                        <div class="media-img" style="background-color: #{{ $media->format->color }};"></div>
                    @endif

            @endswitch
        </div>

        @if ($media->isDownloadable())
            <div class="col-12 d-xl-none">
                <div class="navigation d-xl-none">
                    <input type="image" class="btn btn-xl download btn-download" title="{{ __('Descargar') }}" src="{{ url('svg/icons/download.svg') }}" value="{{ __('Descargar') }}">
                </div>
            </div>
        @endif
    </div>
</div>

<div id="navigation" class="d-none">
    <div class="navigation">
        <input type="image" class="btn btn-lg close" title="{{ __('Cerrar') }}" src="{{ url('svg/icons/close.svg') }}" value="{{ __('Cerrar') }}">
    </div>
</div>
@endsection

@section('css')
@if (in_array($media->format_id, [\App\Format::VIDEO, \App\Format::AUDIO]))
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.4/plyr.css" integrity="sha256-4SvWmlRL7KHo+mpXU1+JNV9mQ1fEKltpEwTFQNuxMiM=" crossorigin="anonymous" />
@endif
@endsection

@section('js')
@if (in_array($media->format_id, [\App\Format::VIDEO, \App\Format::AUDIO]))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.4/plyr.min.js" integrity="sha256-Op3oHR9A1cd3EXT6CDh0J3ob7Z6looIfI+hP095FnN4=" crossorigin="anonymous"></script>
@endif
<script>
    @if (\App\Format::VIDEO == $media->format_id)
        const player = new Plyr('#player', {
            youtube: {
                noCookie: false,
                rel: 0,
                showinfo: 0,
                iv_load_policy: 3,
                modestbranding: 1
            }
        });
    @elseif (\App\Format::AUDIO == $media->format_id)
        const player = new Plyr('#player');
    @endif

    $(function () {
        @if (in_array($media->format_id, [\App\Format::VIDEO, \App\Format::AUDIO]))
            $('.player-preview-container').click(function (e) {
                $(this).closest('.wrapper-player').addClass('play');
                player.play();
            });
        @endif

        $('#navbar-main > *').not('a').css('display', 'none');
        if (! $('#navbar-main > .navigation').length) {
            $('#navbar-main').append($('#navigation').html());
            submitImageHover();
        }

        @if ($media->isDownloadable())
            $('.btn-download').click(function (e) {
                @if ($media->external)
                    window.open('{{ $media->link }}', '_blank');
                @else
                    window.location.href = '{{ route('media.download', $media->id) }}';
                @endif
            });
        @endif

        $('[type="image"].close').click(function (e) {
            window.location.href = '{{ route($routeClose) }}?close=true';
        });
    });
</script>
@endsection
