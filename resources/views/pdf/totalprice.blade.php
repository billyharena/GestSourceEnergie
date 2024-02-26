<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #3dd5f3;
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
        tfoot{
            background-color: #0a53be;
        }
    </style>
</head>
<body>
<h1>Tableau de production d'énergie par heure</h1>
<table class="table">
    <thead>
    <tr>
        <th>Horaire</th>
        <th>Solaire</th>
        <th>Jirama</th>
        <th>Groupe</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @for($i = 8; $i <= 16; $i++)
        <tr>
            <td>{{ $i . 'h' }}</td>
            <td>
                @if (isset($listeS[$i - 8]))
                    {{ number_format($listeS[$i - 8], 2) }} W
                @else
                    N/A
                @endif
            </td>
            <td>
                @if (isset($listeJ[$i - 8]))
                    {{ number_format($listeJ[$i - 8], 2) }} W
                @else
                    N/A
                @endif
            </td>
            <td>
                @if (isset($listeG[$i - 8]))
                    {{ number_format($listeG[$i - 8], 2) }} W
                @else
                    N/A
                @endif
            </td>
            <td>
                @if (isset($tabProd[$i - 8]))
                    {{ number_format($tabProd[$i - 8], 2) }} W
                @else
                    N/A
                @endif
            </td>
        </tr>
    @endfor
    </tbody>
    <tfoot>
    <th>Coût total</th>
    <td>{{ number_format($priceS, 2) }} AR</td>
    <td>{{ number_format($priceJ, 2) }} AR</td>
    <td>{{ number_format($priceG, 2) }} AR</td>
    <td>{{ number_format($total, 2) }} AR</td>
    </tr>
    </tfoot>
</table>
</body>
</html>
