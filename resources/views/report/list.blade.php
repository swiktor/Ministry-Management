@extends('layouts.main')

@section('content')

    <div class="card mt-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Lista służb</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Lp</th>
                                <th>Z kim</th>
                                <th>Typ</th>
                                <th>Kiedy</th>
                                <th>Godziny</th>
                                <th>Publikacje</th>
                                <th>Filmy</th>
                                <th>Odwiedziny</th>
                                <th>Studia</th>
                                <th>Szczegóły</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Lp</th>
                                <th>Z kim</th>
                                <th>Typ</th>
                                <th>Kiedy</th>
                                <th>Godziny</th>
                                <th>Publikacje</th>
                                <th>Filmy</th>
                                <th>Odwiedziny</th>
                                <th>Studia</th>
                                <th>Szczegóły</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($ministries ?? [] as $ministry)
                                <tr>
                                    <td class="align-middle">{{ $ministry->id }}</td>
                                    <td class="align-middle">
                                        @foreach ($ministry->coworkers as $coworker)
                                        {{$coworker->name . ' ' .$coworker->surname }}{!! "<br>" !!}
                                        @endforeach
                                    </td>
                                    <td class="align-middle">{{data_get($ministry,'types.name')}}</td>
                                    <td class="align-middle">{{$ministry->when->format('d.m.Y H:i')}}
                                    <td class="align-middle">{{data_get($ministry,'reports.hours')->format('H:i')}}</td>
                                    <td class="align-middle">{{data_get($ministry,'reports.placements')}}</td>
                                    <td class="align-middle">{{data_get($ministry,'reports.videos')}}</td>
                                    <td class="align-middle">{{data_get($ministry,'reports.returns')}}</td>
                                    <td class="align-middle">{{data_get($ministry,'reports.studies')}}</td>

                                    <td class="align-middle">
                                        <a href="{{$ministry->user_id }}">Szczegóły</a>
                                        {{-- <a href="#">Szczegóły</a> --}}
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
