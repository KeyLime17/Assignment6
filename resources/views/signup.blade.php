<!DOCTYPE html>
<html>
<head>
    <title>Newsletter Signup</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Add your CSS styling here if needed -->
</head>
<body>
    <h1>Sign Up for the Cryptocurrency Newsletter</h1>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('signup.process') }}" method="POST">
        @csrf

        <!-- Name -->
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
        </div>

        <!-- Email -->
        <div>
            <label for="email">E-mail Address:</label>
            <input type="text" name="email" id="email" value="{{ old('email') }}">
        </div>

        <!-- Newsletter Frequency -->
        <div>
            <label>Newsletter Frequency:</label><br>
            <input type="radio" name="frequency" id="daily" value="daily" {{ old('frequency')=='daily' ? 'checked' : '' }}>
            <label for="daily">Daily at midnight</label><br>

            <input type="radio" name="frequency" id="hourly" value="hourly" {{ old('frequency')=='hourly' ? 'checked' : '' }}>
            <label for="hourly">Hourly</label><br>

            <input type="radio" name="frequency" id="every_minute" value="every_minute" {{ old('frequency')=='every_minute' ? 'checked' : '' }}>
            <label for="every_minute">Every minute</label>
        </div>

        <!-- Cryptocurrency Tickers -->
        <div>
            <label>Select Cryptocurrency Tickers:</label><br>
            @php
                $tickers = ['btc' => 'BTC', 'eth' => 'ETH', 'doge' => 'DOGE', 'ltc' => 'LTC', 'xrp' => 'XRP', 'bch' => 'BCH', 'eos' => 'EOS', 'bnb' => 'BNB', 'ada' => 'ADA', 'dot' => 'DOT'];
            @endphp
            @foreach ($tickers as $ticker => $label)
                <input type="checkbox" name="{{ $ticker }}" id="{{ $ticker }}" {{ old($ticker) ? 'checked' : '' }}>
                <label for="{{ $ticker }}">{{ $label }}</label><br>
            @endforeach
        </div>

        <!-- Percentage Change Alert -->
        <div>
            <label for="percentage_alert">Percentage Change Alert:</label>
            <input type="text" name="percentage_alert" id="percentage_alert" value="{{ old('percentage_alert') }}">
        </div>

        <!-- Captcha -->
        <div>
            <label for="captcha">Captcha:</label><br>
            <img src="{{ captcha_src() }}" alt="captcha" id="captcha-img"><br>
            <button type="button" id="reload-captcha">Reload Captcha</button><br>
            <input type="text" name="captcha" id="captcha" placeholder="Enter captcha">
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit">Sign Up</button>
        </div>
    </form>

    <!-- AJAX for captcha reload -->
    <script>
        document.getElementById('reload-captcha').addEventListener('click', function(){
            fetch('{{ route('reload.captcha') }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('captcha-img').src = data.captcha;
                });
        });
    </script>
</body>
</html>
