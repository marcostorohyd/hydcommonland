<nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-second">
    <div class="pr-3">{{ __('Hola, :name', ['name' => auth()->user()->email]) }}</div>
    <ul class="navbar-nav ml-sm-auto">
        <li>
            <a class="mr-3" href="{{ route('home') }}">
                {{ __('Volver a la web') }}
            </a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Salir') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
