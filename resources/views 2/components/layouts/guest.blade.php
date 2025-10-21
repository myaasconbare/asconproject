<!DOCTYPE html>
<html lang="en" color-scheme="light">

<head>
    @include('guest.partials.meta')
    <link rel="shortcut icon" href="{{ asset('files/J5vHPX2wYHRu3fon-2.png') }}" type="image/x-icon">
    @include('guest.partials.css')

    @vite(['resources/js/app.js'])
</head>

<body class="tt-magic-cursor">
    <div id="magic-cursor">
        <div id="ball"></div>
    </div>
   
    @sectionMissing('auth')
        @include('guest.partials.topbar')
    @endif

    @sectionMissing('auth')
        @include('guest.partials.header')
    @endif

    @hasSection('breadcrumb')
        @yield('breadcrumb')
    @endif

    @hasSection('content')
        @yield('content')
    @else
        {{ $slot }}
    @endif

    @sectionMissing('auth')
        @include('guest.partials.footer')
    @endif

    @include('guest.partials.cookie')

    @include('guest.partials.scripts')
</body>
</html>