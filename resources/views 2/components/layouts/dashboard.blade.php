<!DOCTYPE html>
<html lang="en" dir="ltl" data-sidebar="open" color-scheme="light">
    <head>
        @include('guest.partials.meta')

        <link rel="shortcut icon" href="../assets/files/J5vHPX2wYHRu3fon-1.png" type="image/x-icon" />

        @include('user.partials.css')
        <link rel="stylesheet" href="{{ asset('theme/user/css/main.css') }}"/>

        @vite(['resources/js/app.js'])
    </head>

    <body>
        <div class="overlay-bg" id="overlay"></div>
       
        <livewire:user.partials.header/>

        <div class="dashboard-wrapper">
            
            <livewire:user.partials.sidebar/>

            {{ $slot }}
        </div>

        @include('guest.partials.scripts')

        <script src="{{ asset('theme/user/js/script-1.js') }}"></script>

    </body>
</html>
