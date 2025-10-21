<header class="d-header">
    <div class="container-fluid px-0">
        <div class="row align-items-cener">
            <div class="col-lg-5 col-6 d-flex align-items-center">
                <div class="d-header-left">
                    <div class="sidebar-button" id="dash-sidebar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-6">
                <div class="d-header-right">
                    <div class="i-dropdown user-dropdown dropdown">
                        <div class="user-dropdown-meta dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <div class="user-img">
                                <img src="{{ auth()->user()->avatar_url }}" alt="Profile image" />
                            </div>
                            <div class="user-dropdown-info">
                                <p></p>
                            </div>
                        </div>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span>Welcome !</span>
                            </li>
                            @if(session()->has('view_details'))
                            <li>
                                <a class="dropdown-item" href="{{ session('view_details.referrer_page') }}">
                                    Back To Admin
                                </a>
                            </li>
                            @endif

                            <li>
                                <a class="dropdown-item" href="{{ route('user.wallet-top-up') }}">
                                    Wallet Top-Up
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/logout">
                                    Log Out
                                </a>

                                <form id="logout-form" method="POST" action="/logout">
                                    <input type="hidden" name="_token" value="ZyDveNXawIL2DDPM1j7DRuPYQzXeExy4KYf0dkVv" autocomplete="off" />
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>