@php
if (isset($team)){
foreach ($team->coworkers as $coworker) {
$coworkerArray[] = $coworker->id;
}
}
@endphp

@extends('layouts.main')

@section('title', "$title służbę")

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $title }} służbę</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('ministry.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="coworker" class="col-md-4 col-form-label text-md-right">Wybierz współpracowników
                            </label>
                            <div class="col-md-6">
                                @if (isset($team))
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
                                @else
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
                                @endif
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
                                    Umów służbę
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