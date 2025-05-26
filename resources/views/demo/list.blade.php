<div class="row">
    <div class="col-auto ml-lg-auto">
        {{ $demos->links() }}
    </div>
</div>

<div class="row">
    <div class="col-12">
        @forelse ($demos as $item)
            <div class="row">
                <div class="col-12">
                    <small class="text-uppercase">{{ $item->date->format('d M Y') }}</small>
                </div>
                <div class="col-12 col-xl-4 order-xl-1 mb-2">
                    <a href="{{ route('demo.show', $item->id) }}"><img class="img-fluid demo-image" src="{{ $item->imageUrl() }}" alt=""></a>
                </div>
                <div class="col-12 col-xl-4 mb-2">
                    <div class="h-100 border-top pt-2 pt-lx-0">
                        <h2>
                            <a href="{{ route('demo.show', $item->id) }}?current={{ $loop->index + $demos->currentPage() }}">{{ $item->name }}</a>
                        </h2>
                    </div>
                </div>
                <div class="col-12 col-xl-4 mb-4">
                    <div class="row mx-0 border-top font-sm">
                        <div class="col">
                            <dl class="row mb-0">
                                @if (! empty($item->country_id))
                                    <dt class="col-4 pl-0">{{ __('País') }}</dt>
                                    <dd class="col-8">{{ $item->country->name }}</dd>
                                @endif
                                @if (! empty($item->link))
                                    <dt class="col-4 pl-0">{{ __('Enlace') }}</dt>
                                    <dd class="col-8"><a href="{{ $item->link }}" target="_blank">{{ $item->link }}</a></dd>
                                @endif
                                @if (! empty($demo->email))
                                    <dt class="col-4 pl-0">{{ __('Contacto') }}</dt>
                                    <dd class="col-8"><a href="mailto:{{ $demo->email }}" target="_blank">{{ $demo->email }}</a></dd>
                                @endif
                            </dl>
                        </div>
                    </div>
                    <div class="row mx-0 mt-3 mb-2">
                        <div class="col-12 pl-0">
                            <ul class="list-values d-none d-md-block">
                                @foreach ($item->values as $value)
                                    <li><span style="background-color: #{{ $value->color }}" title="{{ $value->name }}"></span></li>
                                @endforeach
                            </ul>
                            <ul class="list-values d-md-none">
                                @foreach ($item->values as $value)
                                    <li><img src="{{ $value->imageMiniUrl() }}" alt="{{ $value->name }}" title="{{ $value->name }}"></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-danger">{{ __('No se han encontrado resultados') }}</p>
        @endforelse
    </div>
</div>

<div class="row">
    <div class="col-auto ml-lg-auto">
        {{ $demos->links() }}
    </div>
</div>
