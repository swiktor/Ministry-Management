@extends('layouts.main')

@section('title', 'Lista propozycji')

@section('content')

    <div class="card mt-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Lista propozycji</div>
            <div class="card-body">
                @if (!empty($when))
                    <form class="form-inline" action="{{ route('ministry.list') }}">
                        <div class="form-row">
                            <label class="my-1 mr-2" for="when">Wybierz miesiąc:</label>
                            <div class="col">
                                <input type="month" class="form-control" name="when" placeholder=""
                                    value="{{ $when ?? '' }}">
                            </div>
                            <button type="submit" class="btn btn-primary mb-1">Wyszukaj</button>
                        </div>
                    </form>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered text-center table-striped" id="dataTable" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th class="align-middle">Lp</th>
                                <th class="align-middle">Z kim</th>
                                <th class="align-middle">Kiedy</th>
                                <th class="align-middle">Opcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="align-middle">Lp</th>
                                <th class="align-middle">Z kim</th>
                                <th class="align-middle">Kiedy</th>
                                <th class="align-middle">Opcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($ministries ?? [] as $key => $ministry)
                                <tr>
                                    <td class="align-middle">{{ $ministries->firstItem() + $key }}</td>
                                    <td class="align-middle">
                                        @foreach ($ministry->coworkers as $coworker)
                                            {{ $coworker->name . ' ' . $coworker->surname }}{!! '<br>' !!}
                                        @endforeach
                                    </td>
                                    <td class="align-middle">{{ $ministry->when->locale('pl')->dayName }},
                                        {{ $ministry->when->format('d.m.Y H:i') }}</td>

                                    <td class="align-middle">
                                        @if (!auth()->user()->googleAccounts->isEmpty())
                                            <a href="{{ route('ministry.proposal.accept', ['id' => $ministry->id]) }}">
                                                <button class="btn btn-success">Zaakceptuj</button>
                                            </a>
                                        @endif
                                        <a href="{{ route('ministry.proposal.reject', ['id' => $ministry->id]) }}">
                                            <button onclick="return confirm('Czy na pewno chcesz usunąć tę propozycję?')"
                                                class="btn btn-danger">Odrzuć</button>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $ministries->links() }}
            </div>
        </div>
    </div>
@endsection
