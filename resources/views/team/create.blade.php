@extends('layouts.main')

@section('title', 'Utwórz grupę')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Utwórz grupę</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('team.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nazwa grupy</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="coworker" class="col-md-4 col-form-label text-md-right">Wybierz współpracowników
                                </label>
                                <div class="col-md-6">
                                    <div class="dropdown bootstrap-select show-tick">
                                        <select class="selectpicker form-control @error('coworker') is-invalid @enderror"
                                            name="coworker[]" multiple data-live-search="true" required>
                                            @foreach ($coworkers as $coworker)
                                                <option value={{ $coworker->id }}>
                                                    {{ $coworker->name . ' ' . $coworker->surname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('coworker')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Dodaj grupę
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
