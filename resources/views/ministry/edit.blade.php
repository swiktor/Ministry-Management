@php
foreach ($ministry[0]->coworkers as $coworker_old) {
    $coworkerArray[] = $coworker_old->id;
}
@endphp

@extends('layouts.main')

@section('title', 'Edytuj służbę')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edytuj służbę</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('ministry.edit') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="coworker" class="col-md-4 col-form-label text-md-right">Wybierz współpracowników
                                </label>

                                <div class="col-md-6">
                                    <div class="dropdown bootstrap-select show-tick">
                                        <select class="selectpicker form-control @error('coworker') is-invalid @enderror"
                                            name="coworker[]" multiple data-live-search="true" required>
                                            @foreach ($coworkers as $coworker)
                                                @if (in_array($coworker->id, $coworkerArray))
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

                            <div class="form-group row">
                                <label for="when" class="col-md-4 col-form-label text-md-right">Wybierz datę i
                                    godzinę</label>
                                <div class="col-md-6">
                                    <input type="datetime-local" id="when" name="when"
                                        value="{{ $ministry[0]->when->format('Y-m-d\TH:i') ?? '' }}"
                                        class="form-control @error('when') is-invalid @enderror" required>
                                    @error('when')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Zatwierdź służbę
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" value="{{ $ministry[0]->id }}" name="id">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
