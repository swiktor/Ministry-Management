@extends('layouts.main')

@section('title', 'Lista zborów')

@section('content')

    <div class="card mt-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Lista zborów</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="align-middle">Lp</th>
                                <th class="align-middle">Nazwa zboru</th>
                                <th class="align-middle">Opcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="align-middle">Lp</th>
                                <th class="align-middle">Nazwa zboru</th>
                                <th class="align-middle">Opcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($congregations ?? [] as $congregation)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $congregation->name}}
                                    <td class="align-middle">
                                        <a
                                            href="{{ route('coworker.list', ['congregation' => $congregation->id]) }}">
                                            <button class="btn btn-info">Osoby ze zboru</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $congregations->links() }}
            </div>
        </div>
    </div>
@endsection
