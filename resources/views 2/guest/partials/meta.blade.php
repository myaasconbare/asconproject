<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
@hasSection('title')
    <title>@yield('title')</title>
@else
    <title>
        {{ $title ?? env("APP_NAME") }}
    </title>
@endif

@hasSection('title')
    <meta name="title" content="@yield('title')">
@else
    <meta name="title" content="{{ $title ?? env("APP_NAME") }}">
@endif

<meta name="description" content="Empower Your Crypto Journey with {{ config("app.name") }} - a platform dedicated to matrix investment strategies, high-yield investment programs (HYIP), and sophisticated trading options for cryptocurrencies like BTC and more. Enhance your financial portfolio through informed crypto investment and trading.">
<meta name="keywords" content="crypto,trade,BTC,crypto investment,crypto trading,crypto trade,trading,matrix-investment,HYIP investment">
<link rel="shortcut icon" href="{{ asset('files/JTv4R3gv636rXHp0-1.jpg') }}" type="image/x-icon">

<link rel="apple-touch-icon" href="{{ asset('files/Nh7ZzZH3wQnAoPWb-1.png') }}">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="{{ config("app.name") }} - Trading for everyone">

<meta itemprop="name" content="{{ config("app.name") }} - Trading for everyone">
<meta itemprop="description" content="Empower Your Crypto Journey with {{ config("app.name") }} - a platform dedicated to matrix investment strategies, high-yield investment programs (HYIP), and sophisticated trading options for cryptocurrencies like BTC and more. Enhance your financial portfolio through informed crypto investment and trading.">
<meta itemprop="image" content="{{ asset('files/JTv4R3gv636rXHp0.jpg') }}">

<meta property="og:type" content="website">
<meta property="og:title" content="{{ config("app.name") }}: Revolutionize Your Financial Portfolio with Leading Crypto Investment and Trading Platform">
<meta property="og:description" content="Empower Your Crypto Journey with {{ config("app.name") }} - a platform dedicated to matrix investment strategies, high-yield investment programs (HYIP), and sophisticated trading options for cryptocurrencies like BTC and more. Enhance your financial portfolio through informed crypto investment and trading.">
<meta property="og:image" content="{{ asset('files/JTv4R3gv636rXHp0.jpg') }}">
<meta property="og:url" content="{{ request()->url() }}">