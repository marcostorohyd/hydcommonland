<li class="nav-item{{ request()->is('backend') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('backend.dashboard') }}" title="{{ __('Inicio') }}">{{ __('Inicio') }}</a>
</li>
@if (Auth::user()->isAdmin())
    <li class="nav-item{{ request()->is('*/directory*') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('backend.directory.index') }}" title="{{ __('Usuarios/as') }}">{{ __('Usuarios/as') }}</a>
    </li>
@else
    <li class="nav-item{{ request()->is('*/account*') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('backend.account.show') }}" title="{{ __('Perfil') }}">{{ __('Perfil') }}</a>
    </li>
@endcan
<li class="nav-item{{ request()->is('*/media*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('backend.media.index') }}" title="{{ __('Media') }}">{{ __('Media') }}</a>
</li>
<li class="nav-item{{ request()->is('*/event*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('backend.event.index') }}" title="{{ __('Eventos') }}">{{ __('Eventos') }}</a>
</li>
<li class="nav-item{{ request()->is('*/new*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('backend.news.index') }}" title="{{ __('Noticias') }}">{{ __('Noticias') }}</a>
</li>
<li class="nav-item{{ request()->is('*/demo*') ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('backend.demo.index') }}" title="{{ __('Casos demostrativos') }}">{{ __('Casos demostrativos') }}</a>
</li>
@if (auth()->user()->isAdmin())
    <li class="nav-item{{ request()->is('*/country*') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('backend.country.index') }}" title="{{ __('Países') }}">{{ __('Países') }}</a>
    </li>
    <li class="nav-item{{ request()->is('*/about*') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('backend.about.edit') }}" title="{{ __('Acerca de') }}">{{ __('Acerca de') }}</a>
    </li>
    <li class="nav-item{{ request()->is('*/contact*') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('backend.contact.edit') }}" title="{{ __('Contacto') }}">{{ __('Contacto') }}</a>
    </li>
@endif
