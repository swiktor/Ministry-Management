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
                                <th>Typ</th>
                                <th>Kiedy</th>
                                <th>user_id</th>
                                <th>Szczegóły</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Lp</th>
                                <th>Typ</th>
                                <th>Kiedy</th>
                                <th>user_id</th>
                                <th>Szczegóły</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($ministries ?? [] as $ministry)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ministry->type_id }}</td>
                                    <td>{{ $ministry->when }}</td>
                                    <td>{{ $ministry->user_id }}</td>
                                    <td>
                                        {{-- <a href="{{ route('games.show', ['ministry' => $ministry->id]) }}">Szczegóły</a> --}}
                                        <a href="#">Szczegóły</a>
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
