@extends('layouts.main')

@section('title', 'Współpracownicy')

@section('content')

    <div class="card mt-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Współpracownicy</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">Lp</th>
                                <th class="text-center">Imię i nazwisko</th>
                                <th class="text-center">Opcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="text-center">Lp</th>
                                <th class="text-center">Imię i nazwisko</th>
                                <th class="text-center">Opcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($coworkers ?? [] as $coworker)
                                <tr>
                                    {{-- @dd($coworker) --}}
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $coworker->name }} {{ $coworker->surname }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('coworker.ministry.list', ['id' => $coworker->id]) }}">
                                            <button class="btn btn-info">Lista służb</button>
                                        </a>
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
