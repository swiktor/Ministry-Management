@extends('layouts.main')

@section('title', 'Lista służb')

@section('content')

    <div class="card mt-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Lista służb</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="align-middle">Lp</th>
                                <th class="align-middle">Z kim</th>
                                <th class="align-middle">Typ</th>
                                <th class="align-middle">Kiedy</th>
                                <th class="align-middle">Szczegóły</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="align-middle">Lp</th>
                                <th class="align-middle">Z kim</th>
                                <th class="align-middle">Typ</th>
                                <th class="align-middle">Kiedy</th>
                                <th class="align-middle">Szczegóły</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($ministries ?? [] as $ministry)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">
                                    @foreach ($ministry->coworkers as $coworker)
                                    {{$coworker->name . ' ' .$coworker->surname }}{!! "<br>" !!}
                                    @endforeach
                                    </td>
                                    <td class="align-middle">{{ $ministry->types->name }}</td>
                                    <td class="align-middle">{{ $ministry->when->format('d.m.Y H:i') }}</td>
                                    <td class="align-middle">
                                        <a href="{{route('report.edit.form',['id'=>$ministry->reports->id])}}">Szczegóły</a>
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
