@extends('layouts.main')

@section('title', 'Lista służb')

@section('content')

    <div class="card mt-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Lista służb</div>
            <div class="card-body">
                @if (!empty($when))
                    <form class="form-inline" action="{{ route('ministry.index') }}">
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
                            <th class="align-middle">Godziny</th>
                            <th class="align-middle">Publikacje</th>
                            <th class="align-middle">Filmy</th>
                            <th class="align-middle">Odwiedziny</th>
                            <th class="align-middle">Studia</th>
                            <th class="align-middle">Opcje</th>
                        </tr>
                        </thead>
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
                                <td class="align-middle">{{ data_get($ministry, 'reports.hours')->format('H:i') }}
                                </td>

                                <td class="align-middle">{{ data_get($ministry, 'reports.placements') }}</td>
                                <td class="align-middle">{{ data_get($ministry, 'reports.videos') }}</td>
                                <td class="align-middle">{{ data_get($ministry, 'reports.returns') }}</td>
                                <td class="align-middle">{{ data_get($ministry, 'reports.studies') }}</td>

                                <td class="align-middle">
                                    @if (!auth()->user()->googleAccounts->isEmpty())
                                        <a href="{{ route('ministry.edit', $ministry) }}">
                                            <button class="btn btn-warning">Edytuj</button>
                                        </a>
                                        <form action="{{ route('ministry.destroy', $ministry) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Czy na pewno chcesz usunąć tę służbę?')"
                                                    class="btn btn-danger">Usuń
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="align-middle">Lp</th>
                            <th class="align-middle">Z kim</th>
                            <th class="align-middle">Kiedy</th>
                            <th class="align-middle">Godziny</th>
                            <th class="align-middle">Publikacje</th>
                            <th class="align-middle">Filmy</th>
                            <th class="align-middle">Odwiedziny</th>
                            <th class="align-middle">Studia</th>
                            <th class="align-middle">Opcje</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                {{ $ministries->links() }}
            </div>
        </div>
    </div>
@endsection
