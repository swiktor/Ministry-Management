@extends('layouts.main')

@section('title', 'Dodaj współpracownika')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dodaj współpracownika</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('coworker.add') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Imię</label>

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
                                <label for="surname" class="col-md-4 col-form-label text-md-right">Nazwisko</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text"
                                        class="form-control @error('surname') is-invalid @enderror" name="surname" required>

                                    @error('surname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="congregation" class="col-md-4 col-form-label text-md-right">Zbór</label>

                                <div class="col-md-6">
                                    <select class="selectpicker form-control @error('congregation') is-invalid @enderror"
                                        name="congregation" data-live-search="true" required>
                                        <option value="" disabled selected>Kliknij, żeby wybrać z listy</option>
                                        @foreach ($congregations as $congregation)
                                            <option value={{ $congregation->id }}>
                                                {{ $congregation->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('congregation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Dodaj współpracownika
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
