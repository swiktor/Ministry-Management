@extends('layouts.main')

@section('title', 'Lista służb')

@section('content')

    <div class="card mt-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Lista służb</div>
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
                @if ($ministries->isEmpty())
                    Brak służb
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center justify-content-center" id="dataTable"
                            width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="align-middle">Lp</th>
                                    <th class="align-middle">Z kim</th>
                                    <th class="align-middle">Typ</th>
                                    <th class="align-middle">Kiedy</th>
                                    <th class="align-middle">Opcje</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="align-middle">Lp</th>
                                    <th class="align-middle">Z kim</th>
                                    <th class="align-middle">Typ</th>
                                    <th class="align-middle">Kiedy</th>
                                    <th class="align-middle">Opcje</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($ministries ?? [] as $ministry)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">
                                            @foreach ($ministry->coworkers as $coworker)
                                                {{ $coworker->name . ' ' . $coworker->surname }}{!! '<br>' !!}
                                            @endforeach
                                        </td>
                                        <td class="align-middle">
                                            {{ $ministry->types->name . ' (' . $ministry->types->duration->format('H:i') . ')' }}
                                        </td>
                                        <td class="align-middle">{{ $ministry->when->format('d.m.Y H:i') }}</td>
                                        <td class="align-middle">
                                            <a href="{{ route('report.edit.form', ['id' => $ministry->reports->id]) }}">
                                                <button class="btn btn-info">Sprawozdanie</button>
                                            </a>
                                            @if (!auth()->user()->googleAccounts->isEmpty())
                                                <a href="{{ route('ministry.form.edit', ['id' => $ministry->id]) }}">
                                                    <button class="btn btn-warning">Edytuj</button>
                                                </a>
                                                <a
                                                    href="{{ route('ministry.delete', ['id' => $ministry->reports->id]) }}">
                                                    <button class="btn btn-danger">Usuń</button>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $ministries->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection
