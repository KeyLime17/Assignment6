<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Cryptocurrency Newsletter</title>
</head>
<body>
    <h1>Hello, {{ $subscriber->name }}</h1>
    <p>Here is your cryptocurrency newsletter with the latest crypto prices:</p>

    @php
        if ($subscriber->frequency === 'daily') {
            $percentageChangeKey = 'percent_change_24h';
            $changeLabel = '24-hour % Change';
        } else {
            $percentageChangeKey = 'percent_change_1h';
            $changeLabel = '1-hour % Change';
        }
    @endphp

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Ticker</th>
                <th>Price (USD)</th>
                <th>{{ $changeLabel }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickerData as $ticker => $info)
                @php
                    $change = $info[$percentageChangeKey];
                    $alert = $subscriber->percentage_alert;
                    $rowStyle = '';

                    if ($change > $alert) {
                        $rowStyle = 'background-color: #c8e6c9;'; // Light green
                    } elseif ($change < -$alert) {
                        $rowStyle = 'background-color: #ffcdd2;'; // Light red
                    }
                @endphp
                <tr style="{{ $rowStyle }}">
                    <td>{{ strtoupper($ticker) }}</td>
                    <td>{{ $info['price_usd'] }}</td>
                    <td>{{ $change }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>
        If you no longer wish to receive this newsletter,
        <a href="{{ url('/unsubscribe?email=' . urlencode($subscriber->email)) }}">
            click here to unsubscribe
        </a>.
    </p>
</body>
</html>
