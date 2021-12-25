@extends('layouts.main')

@section('title', 'Lista kont Google')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Twoje konto Google</span>
                        @if (sizeof($accounts) == 0)
                            <a class="btn btn-primary btn-sm" href="{{ route('google.store') }}">
                                Dodaj konto Google
                            </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse ($accounts as $account)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $account->name }}</span>
                                    <form action="{{ route('google.destroy', $account) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}

                                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                                            usuń
                                        </button>
                                    </form>
                                </li>
                            @empty
                                <li class="list-group-item">
                                    Pusto...
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @if (sizeof($accounts) != 0)
        <br>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Wybierz kalendarz do zapisywania służby</span>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse ($calendars as $calendar)
                                @if ($calendar->id == auth()->user()->calendar_id)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Obecnie wybrany: <b>{{ $calendar->name }}</b></span>
                                        <form action="{{ route('google.select', $calendar) }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('post') }}
                                        </form>
                                    </li>
                                @else
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $calendar->name }}</span>
                                        <form action="{{ route('google.select', $calendar) }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('post') }}

                                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                Wybierz
                                            </button>
                                        </form>
                                    </li>
                                @endif

                            @empty
                                <li class="list-group-item">
                                    Brak dostępnych kalendarzy.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                      <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Jeśli nie wiesz co wybrać, wybierz ten, zawierający <i><b>Twój adres e-mail</b></i></span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
