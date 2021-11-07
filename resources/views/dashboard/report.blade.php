@extends('layouts.main')

@section('title', 'Sprawozdanie miesięczne')
@section('content')

    <div class="row mt-3">
        <div class="col-x col-xl-3 col-md-6 mb-4">
            <div class="card border-left shadow-sm py-2 h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <form action="{{ route('dashboard.report') }}">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">Wybierz
                                    miesiąc:
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-center"> <input type="month"
                                        class="form-control" name="when" placeholder="" value="{{ $when ?? '' }}">
                                </div>
                                <br>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                                    <button type="submit" class="btn btn-primary mb-1 align-items-center">Wyszukaj</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-x col-xl-3 col-md-6 mb-4">
            <div class="card border-left shadow-sm py-2 h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <form action="{{ route('dashboard.report') }}">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">Wybierz
                                    cel godzinowy:
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                    <select class="selectpicker form-control @error('goal') is-invalid @enderror"
                                        name="goal" data-live-search="true" required>
                                        @foreach ($goals as $goal)
                                            @if ($goal_id == $goal->id)
                                                <option value={{ $goal->id }} selected>
                                                    {{ $goal->name . ' (' . substr($goal->quantum, 0, -3) . ')' }}
                                                </option>
                                            @else
                                                <option value={{ $goal->id }}>
                                                    {{ $goal->name . ' (' . substr($goal->quantum, 0, -3) . ')' }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                                    <button type="submit" class="btn btn-primary mb-1 align-items-center">Zmień</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-x col-xl-3 col-md-6 mb-4">
            <div class="card border-left shadow-sm py-2 h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                                Publikacje
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                {{ $monthSum[0]->s_placements ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-x col-xl-3 col-md-6 mb-4">
            <div class="card border-left shadow-sm py-2 h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">Filmy
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                {{ $monthSum[0]->s_videos ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-video fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-x col-xl-3 col-md-6 mb-4">
            <div class="card border-left shadow-sm py-2 h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                                Godziny</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                {{ $monthSum[0]->s_hours ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-x col-xl-3 col-md-6 mb-4">
            <div class="card border-left shadow-sm py-2 h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                                Odwiedziny
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                {{ $monthSum[0]->s_returns ?? 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-undo fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-x col-xl-3 col-md-6 mb-4">
            <div class="card border-left shadow-sm py-2 h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                                Studia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                {{ $monthSum[0]->s_studies ?? 0}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">


        <div class="col-x col-xl-3 col-md-6 mb-4">
            <div class="card border-left shadow-sm py-2 h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">Suma
                                służby z
                                typów</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                {{ $monthSum[0]->s_types ?? '00:00'}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-x col-xl-3 col-md-6 mb-4">
            <div class="card border-left shadow-sm py-2 h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                                Miesięczny
                                balans godzin
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                {{ $monthSum[0]->hour_difference ?? '00:00' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-x col-xl-3 col-md-6 mb-4">
            <div class="card border-left shadow-sm py-2 h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                                Nadmiar /
                                niedobór godzin
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                {{ $monthSum[0]->real_balance ?? '00:00' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-x col-xl-3 col-md-6 mb-4">
            <div class="card border-left shadow-sm py-2 h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">Cel
                                dzienny
                            </div>
                            @if ($monthSum[0]->real_day_destination >= '00:00')
                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                    {{ $monthSum[0]->real_day_destination }}</div>
                            @else
                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">00:00</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
