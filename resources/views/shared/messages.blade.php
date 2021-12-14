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

    @if (auth()->user()->coworker_id == null)
        <div class="alert alert-danger alert-block mt-2">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Nie połączono jeszcze konta, żeby to zrobić kliknij <a
                    href="{{ route('coworker.link.form') }}">tutaj</a> </strong>
        </div>
    @endif


    @if (isset($ministryProposalUserList) && !count($ministryProposalUserList) == 0)
        <div class="alert alert-info alert-block mt-2">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>
                @if (count($ministryProposalUserList) == 1)
                    Użytkownik {{ $ministryProposalUserList[0]->users_original->name }} {{ $ministryProposalUserList[0]->users_original->surname }}
                    dodał służbę z Tobą, możesz ją sprawdzić <a href="{{ route('ministry.proposal') }}">tutaj</a>
                @else
                    Użytkownicy
                    @foreach ($ministryProposalUserList as $proposal)
                        {{ $proposal->users_original->name }} {{ $proposal->users_original->surname }}@if (!$loop->last),@endif
                    @endforeach
                    dodali slużbę z Tobą, możesz ją sprawdzić <a href="{{ route('ministry.proposal') }}">tutaj</a>
                @endif
            </strong>
        </div>
    @endif
