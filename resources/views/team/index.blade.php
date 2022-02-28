@extends('layouts.main')

@section('title', 'Lista moich grup')
@section('content')

<div class="card mt-3">
    <div class="card">
        <div class="card-header"><i class="fas fa-table mr-1"></i>Lista moich grup</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center table-striped" id="dataTable" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th class="align-middle">Lp</th>
                            <th class="align-middle">Nazwa</th>
                            <th class="align-middle">Osoby</th>
                            <th class="align-middle">Opcje</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="align-middle">Lp</th>
                            <th class="align-middle">Nazwa</th>
                            <th class="align-middle">Osoby</th>
                            <th class="align-middle">Opcje</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($teams ?? [] as $key => $team)
                        <tr>
                            <td class="align-middle">{{ $teams->firstItem() + $key }}</td>
                            <td class="align-middle">
                                {{ $team->name }}
                            </td>
                            <td class="align-middle">
                                @foreach ($team->coworkers as $coworker)
                                {{ $coworker->name . ' ' . $coworker->surname }}{!! '<br>' !!}
                                @endforeach
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('team.ministry', $team) }}">
                                    <button class="btn btn-info">Umów służbę z grupą</button>
                                </a>
                                <br>
                                <a href="{{ route('team.edit', $team) }}">
                                    <button class="btn btn-warning">Edytuj</button>
                                </a>
                                <br>
                                <form action="{{ route('team.destroy', $team) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Czy na pewno chcesz usunąć tę grupę?')"
                                        class="btn btn-danger">Usuń
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $teams->links() }}
        </div>
    </div>
</div>
@endsection