<div class="row">
    <div class="col-auto ml-0 ml-sm-auto ml-lg-0">
        {{ $directories->links() }}
    </div>
</div>

<div class="list-wrapper list list-detail">
    @if ($group->count())
        <ul class="list-three-columns">
            @foreach ($group as $letter => $directories)
                <li class="index {{ $directories->count() > 1 ? '' : 'last' }}"><strong>{{ $letter }}</strong>

                @foreach ($directories as $directory)
                    @if (! $loop->first)
                        <li class="{{ $loop->last ? 'last' : '' }}">
                    @endif
                    <a href="{{ route('directory.show', $directory->id) }}">{{ $directory->name }}</a></li>
                @endforeach
            @endforeach
        </ul>
    @else
        <p class="text-danger">{{ __('No se han encontrado resultados') }}</p>
    @endif
</div>

{{-- <div class="list-wrapper list list-detail list-grid-row">
    @forelse ($group as $letter => $directories)
        @if ($loop->iteration > $loop->count - floor($loop->count / 3))
            <div class="three">
        @elseif ($loop->iteration > ceil($loop->count / 3))
            <div class="two">
        @else
            <div>
        @endif
            <strong>{{ $letter }}</strong>
            <ul>
                @foreach ($directories as $directory)
                    <li><a href="{{ route('directory.show', $directory->id) }}">{{ $directory->name }}</a></li>
                @endforeach
            </ul>
        </div>
    @empty
        <p class="text-danger">{{ __('No se han encontrado resultados') }}</p>
    @endforelse
</div> --}}
