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
                                <th>Lp</th>
                                <th>Nazwisko</th>
                                <th>Imię</th>
                                <th>Szczegóły</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Lp</th>
                                <th>Nazwisko</th>
                                <th>Imię</th>
                                <th>Szczegóły</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($coworkers ?? [] as $coworker)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $coworker->surname }}</td>
                                    <td>{{ $coworker->name }}</td>
                                    <td>
                                        {{-- <a href="{{ route('games.show', ['game' => $coworker->id]) }}">Szczegóły</a> --}}
                                        <a href="#">Szczegóły</a>
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
