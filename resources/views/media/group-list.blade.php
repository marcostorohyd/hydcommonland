@php $flag = true @endphp
@foreach ($group as $item)
    @if (! empty($item->count()))
        @php $flag = false @endphp
        <div class="row">
            <div class="col-12">
                <h4 class="border-bottom border-2x" style="border-color: #{{ $item[0]->format->color }} !important;">
                    <strong>{{ $item[0]->format->name }}</strong>
                </h4>
            </div>
        </div>

        <div class="row px-4">
            <div class="col-12">
                <div class="row carousel carousel-format carousel-{{ $item[0]->format->media_collection }}">
                    @foreach ($item as $library)
                        <div class="col-12 col-sm-6 col-md-4 slick-col-auto">
                            <p class="text-uppercase border-bottom">{{ $library->date->format('d M Y') }}</p>
                            <div class="media-item">
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
                                                <span class="icon icon-chevron-left icon-lg" aria-hidden="true"></span>
                                                <span class="sr-only">{{ __('Anterior') }}</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselControls-{{ $library->id }}" role="button" data-slide="next">
                                                <span class="icon icon-chevron-right icon-lg" aria-hidden="true"></span>
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
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mb-5 mt-1 border-bottom border-2x" style="border-color: #{{ $item[0]->format->color }} !important;"></div>
    @endif
@endforeach

@if ($flag)
    <p class="text-danger">{{ __('No se han encontrado resultados') }}</p>
@endif
