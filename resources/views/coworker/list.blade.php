@extends('layouts.main')

@section('title', 'Współpracownicy')

@section('content')

    <div class="card mt-3">
        <div class="card">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Współpracownicy</div>
            <div class="card-body">
                {{-- @dump($congregations) --}}
                @if (!empty($congregations))
                    <form class="form-inline" action="{{ route('coworker.list') }}">
                        <div class="form-row">
                            <label class="my-1 mr-2" for="when">Wybierz zbór:</label>
                            <div class="col">
                                <select class="selectpicker form-control @error('congregation') is-invalid @enderror"
                                    name="congregation" data-live-search="true" required>
                                    @foreach ($congregations as $congregation)
                                        @if ($congregation->id == $congregation_selected)
                                            {
                                            <option value={{ $congregation->id }} selected>
                                                {{ $congregation->name }}
                                            </option>
                                            }
                                        @else
                                            <option value={{ $congregation->id }}>
                                                {{ $congregation->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
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
                                <th class="text-center">Opcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="text-center">Lp</th>
                                <th class="text-center">Nazwisko</th>
                                <th class="text-center">Imię</th>
                                <th class="text-center">Opcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($coworkers ?? [] as $coworker)
                                <tr>
                                    {{-- @dd($coworker) --}}
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $coworker->surname }}</td>
                                    <td class="text-center">{{ $coworker->name }}</td>
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
