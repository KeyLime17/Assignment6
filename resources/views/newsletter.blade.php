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
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
        }
        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <h1>Crypto Newsletter</h1>
    <p>Here is your cryptocurrency newsletter with the latest crypto prices:</p>

    <!-- Table for coin data -->
    <table>
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Price (USD)</th>
                <th>Percent Change (24h)</th>
                <th>Percent Change (1h)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coins as $coin)
                <tr>
                    <td>{{ $coin['symbol'] }}</td>
                    <td>{{ $coin['price_usd'] }}</td>
                    <td @class(['up' => $coin['percent_change_24h'] > 0, 'down' => $coin['percent_change_24h'] < 0])>
                        {{ $coin['percent_change_24h'] }}
                    </td>
                    <td @class(['up' => $coin['percent_change_1h'] > 0, 'down' => $coin['percent_change_1h'] < 0])>
                        {{ $coin['percent_change_1h'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br />
    
    <p>If you no longer wish to receive this newsletter, 
        <a href="{{ route('unsubscribe', ['email' => urlencode($subscriber->email)]) }}">
            click here to unsubscribe.
        </a>
    </p>

</body>
</html>
