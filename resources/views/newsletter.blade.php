

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Newsletter</title>
</head>
<body>

    <h1>Newsletter</h1>
    <p>Here is your newsletter with the latest crypto prices</p>

    @php
        if ($subscriber->frequency === 'daily') {
            $percentageChangeKey = 'percent_change_24h';
            
        }
    @endphp

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Ticker</th>
                <th>Price</th>
                <th>{{ $changeLabel}}

</body>
</html>