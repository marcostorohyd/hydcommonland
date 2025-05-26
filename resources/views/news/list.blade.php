<div class="row">
    <div class="col-auto ml-lg-auto">
        {{ $news->links() }}
    </div>
</div>

<div class="row">
    @forelse ($news as $item)
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="p-3" style="background-color: #{{ $item->color() }}">
                <p class="text-uppercase border-bottom">{{ $item->date->format('d M Y') }}</p>
                <div class="h-100">
                    <h2>
                        <a href="{{ route('news.show', $item->id) }}">{{ $item->name }}</a>
                    </h2>
                </div>
                <div class="row mx-0 border-top">
                    <div class="col">
                        <dl class="row mb-0">
                            @if (! empty($item->country_id))
                                <dt class="col-4 pl-0">{{ __('País') }}</dt>
                                <dd class="col-8">{{ $item->country->name }}</dd>
                            @endif
                            <dt class="col-4 pl-0">{{ __('Contacto') }}</dt>
                            <dd class="col-8"><a href="mailto:{{ $item->email }}" target="_blank" title="{{ $item->email }}">{{ $item->email }}</a></dd>
                        </dl>
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
