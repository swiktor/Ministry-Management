<!DOCTYPE html>
<html>

<head>
    <title>Nowa propozycja służby</title>
</head>

<body>
    <h2>Witaj {{ $user['name'] }}</h2>

    <h3>Użytkownik {{ $ministry['users_original']->name }}
        {{ $ministry['users_original']->surname }} dodał służbę z Tobą:</h3>

    <h4>Data i godzina:</h4> {{ $ministry['when']->format('d.m.Y H:i') }}
    <br />
    <h4>Współpracownicy:</h4>
    <ul>
        @foreach ($ministry['coworkers'] as $coworker)
            <li>{{ $coworker->name }} {{ $coworker->surname }}</li>
        @endforeach
    </ul>
    <br />
    Kliknij <a href="{{ route('ministry.proposal') }}">tutaj</a> żeby zaakceptować lub odrzucić propozycję.

    <br />

    <h4>Życzę owocnej służby!</h4>
</body>

</html>
