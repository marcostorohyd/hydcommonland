<div class="row">
    <div class="col-auto ml-lg-auto">
        {{ $medias->links() }}
    </div>
</div>

@if (! empty($format))
    <div class="row">
        <div class="col-12">
            <h4 class="border-bottom border-2x" style="border-color: #{{ $format->color }} !important;">
                <strong>{{ $format->name }}</strong>
            </h4>
        </div>
    </div>
@endif

<div class="row">
    @forelse ($medias as $library)
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="p-3">
                <p class="text-uppercase border-bottom">{{ $library->date->format('d M Y') }}</p>
                <div class="h-100 media-item">
                    @if (\App\Format::GALLERY == $library->format_id)
                        @php $gallery = $library->getMedia('gallery') @endphp
                        @if (1 < $gallery->count())
                            <div id="carouselControls-{{ $library->id }}" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($gallery as $media)
                                        <div class="carousel-item {{ $loop->index ? '' : 'active' }}">
                                            <a href="{{ route('media.show', $library->id) }}">
                                                <img class="img-fluid" src="{{ $media->getUrl() }}" alt="">
                                                <div class="format-info" style="background-color: #{{ $library->format->color }};">
                                                    <i class="icon icon-{{ $library->format->media_collection }}"></i> <span class="{{ $library->info($media) ? 'info' : '' }}">{{ $library->info($media) }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselControls-{{ $library->id }}" role="button" data-slide="prev">
                                    <span class="fa fa-chevron-left fa-2x" aria-hidden="true"></span>
                                    <span class="sr-only">{{ __('Anterior') }}</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselControls-{{ $library->id }}" role="button" data-slide="next">
                                    <span class="fa fa-chevron-right fa-2x" aria-hidden="true"></span>
                                    <span class="sr-only">{{ __('Siguiente') }}</span>
                                </a>
                            </div>
                        @elseif ($gallery->count())
                            <a href="{{ route('media.show', $library->id) }}">
                                <img class="img-fluid" src="{{ $gallery[0]->getUrl() }}" alt="">
                                <div class="format-info" style="background-color: #{{ $library->format->color }};">
                                    <i class="icon icon-{{ $library->format->media_collection }}"></i> <span class="{{ $library->info($gallery[0]) ? 'info' : '' }}">{{ $library->info($gallery[0]) }}</span>
                                </div>
                            </a>
                        @else
                            <a href="{{ route('media.show', $library->id) }}">
                                <div class="media-img" style="background-color: #{{ $library->format->color }};"></div>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('media.show', $library->id) }}">
                            @if ($library->image)
                                <img class="img-fluid" src="{{ $library->imageUrl() }}" alt="">
                            @else
                                <div class="media-img" style="background-color: #{{ $library->format->color }};"></div>
                            @endif
                            <div class="format-info" style="background-color: #{{ $library->format->color }};">
                                <i class="icon icon-{{ $library->format->media_collection }}"></i> <span class="{{ $library->info() ? 'info' : '' }}">{{ $library->info() }}</span>
                            </div>
                        </a>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('media.show', $library->id) }}">{{ $library->name }}</a>
                        <br>
                        @if (! empty($library->author))
                            <small>{{ __('Subido por') }} {{ $library->author }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p class="text-danger">{{ __('No se han encontrado resultados') }}</p>
        </div>
    @endforelse
</div>
