<header class="header-area style-1">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="header-left">
            <button class="header-item-btn sidebar-btn d-lg-none d-block">
                <i class="bi bi-bars"></i>
            </button>

            <div class="header-logo">
                <a href="{{ route('guest.home') }}">
                    <h3 class="text-white">
                        {{ config('app.name') }}
                    </h3>
                    {{-- <img src="{{ asset('files/Nh7ZzZH3wQnAoPWb-1.png') }}" alt="White Logo"> --}}
                </a>
            </div>
        </div>

        <div class="main-nav">
            <div class="mobile-logo-area d-xl-none d-flex justify-content-between align-items-center">
                <div class="mobile-logo-wrap">
                    <h3 class="text-white">
                        {{ config('app.name') }}
                    </h3>
                    {{-- <img src="{{ asset('files/Nh7ZzZH3wQnAoPWb-1.png') }}" alt="White Logo"> --}}
                </div>
                <div class="menu-close-btn">
                    <i class="bi bi-x-lg"></i>
                </div>
            </div>
            <ul class="menu-list">
                <li class="menu-item-has-children">
                    <a href="{{ route('guest.home') }}" @class(['dropdown', "active" => request()->routeIs("guest.home") ])">Home</a>
                </li>

                <li class="menu-item-has-children">
                    <a href="{{ route('guest.trade') }}" @class(['dropdown', "active" => request()->routeIs("guest.trade") ])">Markets</a>
                </li>
                {{-- <li><a href="{{ route('guest.pricing') }}" @class(["active" => request()->routeIs("guest.pricing") ])">Pricing</a></li> --}}
                <li><a href="{{ route('guest.features') }}" @class(["active" => request()->routeIs("guest.features") ])">Features</a></li>
                <li>
                    <a href="{{ route('guest.staking') }}" @class(["active" => request()->routeIs("guest.staking") ])">
                        Staking
                    </a>
                </li>
                <li>
                    <a target="_blank" href="https://ascon-united.gitbook.io/ascon-united-docs" @class(["active" => request()->routeIs("guest.contact") ])">
                        Read Docs
                    </a>
            </li>
            </ul>

            @auth
                <a href="{{ route('user.dashboard') }}" class="i-btn btn--md d-xl-none d-flex capsuled btn--primary">Dashboard</a>
            @else
                <a href="{{ route('auth.login') }}" class="i-btn btn--md d-xl-none d-flex capsuled btn--primary">SignIn</a>
            @endauth

        </div>

        <div class="nav-right">
            <div class="dropdown-language">
                <select class="language">
                    <option value="en" selected="">English</option>
                    <option value="it">Italian</option>
                    <option value="my">Malaysia</option>
                    <option value="sp">Spain</option>
                </select>
            </div>

            @auth
                <a href="{{ route('user.dashboard') }}" class="i-btn btn--md d-xl-flex d-none capsuled btn--primary-outline">Dashboard</a>
            @else
                <a href="{{ route('auth.login') }}" class="i-btn btn--md d-xl-flex d-none capsuled btn--primary-outline">SignIn</a>    
            @endauth

            <div class="sidebar-btn d-xl-none d-flex">
                <i class="bi bi-list"></i>
            </div>
        </div>
    </div>
</header>

<script>
    "use strict";
    $(document).ready(function() {
        $('.language').on('change', function() {
            const languageCode = $(this).val();
            changeLanguage(languageCode);
        });

        function changeLanguage(languageCode) {
            $.ajax({
                url: "language-change/" + languageCode,
                method: 'GET',
                success: function(response) {
                    notify('success', response.message);
                    location.reload();
                },
                error: function(error) {
                    console.error('Error changing language', error);
                }
            });
        }
    });
</script>