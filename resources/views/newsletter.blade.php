<!DOCTYPE html>
<html>
<head>
    <title>Your Cryptocurrency Newsletter</title>
    <style>
        .up {
            color: green;
        }
        .down {
            color: red;
        }
        table, tr, th {border: 1px solid black;}
        td, th {padding: 10px;}
        table {border-collapse: collapse;}
    </style>
</head>
<body>
    <h1>Hello, {{ $subscriber->name }}</h1>
    <p>Here is your cryptocurrency newsletter with the latest crypto prices:</p>

    <table>
        <tr><th>Symbol</th><td>{{ $symbol }}</td></tr>
        <tr><th>Price (USD)</th><td>{{ $price_usd }}</td></tr>
        <tr><th>Percent Change (24h)</th>
            <td @class(['up' => $percent_change_24h > 0, 
                'down' => $percent_change_24h < 0])>
                {{ $percent_change_1h }}
            </td>
        </tr>
        <tr><th>Percent Change (1h)</th>
            <td @class(['up' => $percent_change_1h > 0, 
                'down' => $percent_change_1h < 0])>
                {{ $percent_change_1h }}
            </td>
        </tr>
    </table>
    <br />
    <h2>All Tickers</h2>
    <ul>
        @foreach ($alltickers as $ticker)
            <li>{{ $ticker->symbol }}</li>
        @endforeach
    </ul>

</body>
</html>
