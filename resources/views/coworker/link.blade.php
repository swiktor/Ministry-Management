@extends('layouts.main')

@section('title', 'Połącz konto')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Połącz konto</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('coworker.link') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="coworker" class="col-md-4 col-form-label text-md-right">Wybierz siebie
                                </label>

                                <div class="col-md-6">
                                    <div class="dropdown bootstrap-select show-tick">
                                        <select class="selectpicker form-control @error('coworker') is-invalid @enderror"
                                            name="coworker" data-live-search="true" required>
                                            <option value="" disabled selected>Kliknij, żeby wybrać</option>
                                            @foreach ($coworkers as $coworker)
                                                @if ($coworker->id==$user_coworker_id)
                                                    <option selected value={{ $coworker->id }}>
                                                        {{ $coworker->name . ' ' . $coworker->surname }}
                                                    </option>
                                                @else
                                                    <option value={{ $coworker->id }}>
                                                        {{ $coworker->name . ' ' . $coworker->surname }}
                                                    </option>
                                                @endif
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
                                        Połącz
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Jeśli nie możesz się znaleźć, to dodaj się we <i><b>Współpracownicy -> Dodaj</b></i>, a następnie wróć tutaj</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
