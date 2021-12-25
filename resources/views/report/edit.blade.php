@extends('layouts.main')

@section('title', 'Uzupełnij sprawozdanie')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Uzupełnij sprawozdanie</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('report.edit') }}">
                            @csrf

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

                            <input type="hidden" value="{{ $report->id }}" name="id">

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Zatwierdź sprawozdanie
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
