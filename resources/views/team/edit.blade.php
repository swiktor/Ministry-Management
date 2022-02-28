@php
foreach ($team->coworkers as $coworker) {
$coworkerArray[] = $coworker->id;
}
@endphp

@extends('layouts.main')

@section('title', 'Edytuj grupę')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edytuj grupę</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('team.update', $team) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nazwa grupy</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ $team->name }}" required autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="coworkers" class="col-md-4 col-form-label text-md-right">Wybierz
                                współpracowników
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
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Edytuj grupę
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