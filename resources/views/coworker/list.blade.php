@extends('layouts.main')

@section('content')

    <div class="card mt-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Współpracownicy</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="align-middle">Lp</th>
                                <th class="align-middle">Nazwisko</th>
                                <th class="align-middle">Imię</th>
                                <th class="align-middle">Szczegóły</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="align-middle">Lp</th>
                                <th class="align-middle">Nazwisko</th>
                                <th class="align-middle">Imię</th>
                                <th class="align-middle">Szczegóły</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($coworkers ?? [] as $coworker)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $coworker->surname }}</td>
                                    <td class="align-middle">{{ $coworker->name }}</td>
                                    <td class="align-middle">
                                        <a href="{{ route('coworker.ministry.list', ['id' => $coworker->id]) }}">Szczegóły</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $coworkers->links() }}
            </div>
        </div>
    </div>

@endsection
