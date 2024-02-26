<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1, h2 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
<h1>Calendrier</h1>
<table class="table">
    <thead>
    <tr>
        <th>Discipline</th>
        <th>Date</th>
        <th>Lieu</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($liste as $calendrier)
        <tr>
            <td>{{ $calendrier->discipline }}</td>
            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $calendrier->datecalendrier )->locale('fr')->isoFormat('LL') }}</td>
            <td>{{ $calendrier->nomsite }}</td>
    @empty
        <tr>
            <td colspan="5">Aucun programme.</td>
        </tr>
    @endforelse
    </tbody>
</table>
</body>
</html>
