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
                                <label for="coworkers" class="col-md-4 col-form-label text-md-right">Wybierz współpracowników
                                </label>

                                <div class="col-md-6">
                                    <div class="dropdown bootstrap-select show-tick">
                                        <select class="selectpicker form-control @error('coworkers') is-invalid @enderror"
                                            name="coworkers[]" multiple data-live-search="true" required>
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
                                    @error('coworkers')
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

                            <div class="form-group row">
                                <label for="hours" class="col-md-4 col-form-label text-md-right">Godziny</label>
                                <div class="col-md-6">
                                    <input id="hours" type="time" class="form-control @error('hours') is-invalid @enderror"
                                        name="hours" value="{{ $report->hours->format('H:i') }}" required autofocus>
                                    @error('hours')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="placements" class="col-md-4 col-form-label text-md-right">Publikacje</label>
                                <div class="col-md-6">
                                    <input id="placements" type="number"
                                        class="form-control @error('placements') is-invalid @enderror" name="placements"
                                        value="{{ $report->placements }}" required autofocus min="0">
                                    @error('placements')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="videos" class="col-md-4 col-form-label text-md-right">Pokazane filmy</label>
                                <div class="col-md-6">
                                    <input id="videos" type="number"
                                        class="form-control @error('videos') is-invalid @enderror" name="videos"
                                        value="{{ $report->videos }}" required autofocus min="0">
                                    @error('videos')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="returns" class="col-md-4 col-form-label text-md-right">Odwiedziny
                                    ponowne</label>
                                <div class="col-md-6">
                                    <input id="returns" type="number"
                                        class="form-control @error('returns') is-invalid @enderror" name="returns"
                                        value="{{ $report->returns }}" required autofocus min="0">
                                    @error('returns')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="studies" class="col-md-4 col-form-label text-md-right">Liczba różnych studiów
                                    biblijnych</label>
                                <div class="col-md-6">
                                    <input id="studies" type="number"
                                        class="form-control @error('studies') is-invalid @enderror" name="studies"
                                        value="{{ $report->studies }}" required autofocus min="0">
                                    @error('studies')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" value="{{ $report->id }}" name="report_id">

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Zatwierdź służbę
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" value="{{ $ministry[0]->id }}" name="ministry_id">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
