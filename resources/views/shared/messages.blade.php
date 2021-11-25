    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block mt-2">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block mt-2">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($message = Session::get('warning'))
        <div class="alert alert-warning alert-block mt-2">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($message = Session::get('info'))
        <div class="alert alert-info alert-block mt-2">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if (auth()->user()->googleAccounts->isEmpty())
        <div class="alert alert-danger alert-block mt-2">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Nie dodano jeszcze konta Google, żeby to zrobić kliknij <a
                    href="{{ route('google.index') }}">tutaj</a> </strong>
        </div>
    @endif
