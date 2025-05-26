@if (! empty($errors) && count($errors))
    <div class="alert alert-danger fade show" role="alert">
        <p><strong>{{ __('Se han encontrado los siguientes errores:') }}</strong></p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if (Session::has('alert-' . $msg))
        <div role="alert" class="alert alert-{{ $msg }} alert-dismissible fade show mb-4">
            {{-- @if ($msg == 'danger')
                <span class="fa fa-exclamation-circle fa-lg fa-fw" aria-hidden="true"></span>
            @elseif($msg == 'warning')
                <span class="fa fa-info-circle fa-lg fa-fw" aria-hidden="true"></span>
            @elseif($msg == 'success')
                <span class="fa fa-check-circle fa-lg fa-fw" aria-hidden="true"></span>
            @elseif($msg == 'info')
                <span class="fa fa-info-circle fa-lg fa-fw" aria-hidden="true"></span>
            @endif --}}
            <span class="sr-only">{{ $msg }}:</span>
            {{ Session::get('alert-' . $msg) }}
            {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}
        </div>
    @endif
@endforeach
