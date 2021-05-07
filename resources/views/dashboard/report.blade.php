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
                                {{ $monthSum[0]->s_placements }}</div>
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
                                {{ $monthSum[0]->s_videos }}
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
                                {{ $monthSum[0]->s_hours }}
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
                                {{ $monthSum[0]->s_returns }}
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
                                {{ $monthSum[0]->s_studies }}
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                                Miesięczny
                                bilans godzin
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                {{ $monthSum[0]->hour_difference }}</div>
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">Suma
                                służby z
                                typów</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                {{ $monthSum[0]->balance_s_types_quantum }}</div>
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
                                {{ $monthSum[0]->balance_expectations_real }}</div>
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
