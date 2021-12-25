<!DOCTYPE html>
<html>

    <head>
        <title>Twoje miesięczne sprawozdanie</title>
    </head>

    <body>
        <h2>Witaj {{ $user['name'] }}</h2>
        <h3>Oto twoje sprawozdanie za {{ $date['month'] }}/{{ $date['year'] }}:</h3>

        Publikacje: {{ $report[0]->s_placements }}
        <br />
        Pokazane filmy: {{ $report[0]->s_videos }}
        <br />
        Godziny: {{$report[0]->s_hours }}
        <br />
        Odwiedziny ponowne: {{ $report[0]->s_returns }}
        <br />
        Studia biblijne: {{ $report[0]->s_studies }}

        <br />

        <h4>Życzę owocnej służby!</h4>
    </body>

</html>
