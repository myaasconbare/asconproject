<!DOCTYPE html>
<html lang="en" color-scheme="light">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}- Trade now</title>
    <meta name="title" content="{{ config('app.name') }}- Trade now" />
    <meta
      name="description"
      content="Empower Your Crypto Journey with {{ config('app.name') }}- a platform dedicated to matrix investment strategies, high-yield investment programs (HYIP), and sophisticated trading options for cryptocurrencies like BTC and more. Enhance your financial portfolio through informed crypto investment and trading."
    />
    <meta
      name="keywords"
      content="crypto,trade,BTC,crypto investment,crypto trading,crypto trade,trading,matrix-investment,HYIP investment"
    />
    <link
      rel="shortcut icon"
      href="../../../assets/files/JTv4R3gv636rXHp0-1.jpg"
      type="image/x-icon"
    />

    <link
      rel="apple-touch-icon"
      href="../../../assets/files/Nh7ZzZH3wQnAoPWb-1.png"
    />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}- Trade now" />

    <meta itemprop="name" content="{{ config('app.name') }}- Trade now" />
    <meta
      itemprop="description"
      content="Empower Your Crypto Journey with {{ config('app.name') }}- a platform dedicated to matrix investment strategies, high-yield investment programs (HYIP), and sophisticated trading options for cryptocurrencies like BTC and more. Enhance your financial portfolio through informed crypto investment and trading."
    />
    <meta
      itemprop="image"
      content="https://finfunder.kloudinnovation.com/assets/files/JTv4R3gv636rXHp0.jpg"
    />

    <meta property="og:type" content="website" />
    <meta
      property="og:title"
      content="FinFunder: Revolutionize Your Financial Portfolio with Leading Crypto Investment and Trading Platform"
    />
    <meta
      property="og:description"
      content="Empower Your Crypto Journey with {{ config('app.name') }}- a platform dedicated to matrix investment strategies, high-yield investment programs (HYIP), and sophisticated trading options for cryptocurrencies like BTC and more. Enhance your financial portfolio through informed crypto investment and trading."
    />
    <meta
      property="og:image"
      content="https://finfunder.kloudinnovation.com/assets/files/JTv4R3gv636rXHp0.jpg"
    />
    <meta
      property="og:url"
      content="https://finfunder.kloudinnovation.com/users/trades/binary/aave"
    />

    @include('user.partials.css')

   <link rel="stylesheet" href="{{ asset('theme/auth/css/main-1.css') }}">

   @vite(['resources/js/app.js'])

   <style>
    .spin-btn {
    height: 48px;
}
.i-badge.badge--info {
    color: var(--color-purple);
    background-color: var(--color-purple-light);
    border: 1px solid var(--border-purple);
}
   </style>
  </head>

  <body class="tt-magic-cursor">
    <div id="magic-cursor">
      <div id="ball"></div>
    </div>
    <main>
      {{ $slot }}
    </main>
    @include('guest.partials.scripts')

    <script src="{{ asset('theme/user/js/script-1.js') }}"></script>
  </body>
</html>
