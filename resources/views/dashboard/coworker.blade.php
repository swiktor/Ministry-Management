@extends('layouts.main')

@section('title', 'Bilans osobowy')

@section('content')

    <div class="card mt-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Współpracownicy</div>
            <div class="card-body">
                @if (!empty($when))
                <form class="form-inline" action="{{route('dashboard.coworker')}}">
                    <div class="form-row">
                        <label class="my-1 mr-2" for="when">Wybierz miesiąc:</label>
                        <div class="col">
                            <input type="month" class="form-control" name="when" placeholder="" value="{{ $when ?? '' }}">
                        </div>
                        <button type="submit" class="btn btn-primary mb-1">Wyszukaj</button>
                    </div>
                </form>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">Lp</th>
                                <th class="text-center">Nazwisko</th>
                                <th class="text-center">Imię</th>
                                <th class="text-center">Ilość wyruszeń</th>
                                <th class="text-center">Opcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="text-center">Lp</th>
                                <th class="text-center">Nazwisko</th>
                                <th class="text-center">Imię</th>
                                <th class="text-center">Ilość wyruszeń</th>
                                <th class="text-center">Opcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($coworkers ?? [] as $coworker)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $coworker->surname }}</td>
                                    <td class="text-center">{{ $coworker->name }}</td>
                                    <td class="text-center">{{ $coworker->count }}</td>
                                    <td class="text-center">
                                        <a
                                            href="{{ route('coworker.ministry.list', ['id' => $coworker->coworker_id]) }}">
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
