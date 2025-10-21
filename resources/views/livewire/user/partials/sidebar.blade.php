<div class="d-sidebar" id="user-sidebar">
    <div class="sidebar-logo">
        <a href="{{ route('guest.home') }}">
            <h3>
                {{ config('app.name') }}
            </h3>
            {{-- <img src="{{ asset('files/CvuUr9CwYsyU6VVB.png') }}" alt="logo" /> --}}
        </a>
    </div>
    <div class="main-nav sidebar-menu-container">
        <ul class="sidebar-menu">
            {{-- referrer_page --}}

            @if(session()->has('view_details'))
            <x-user.sidebar-menu-item external label="Back To Admin" pattern="{{ session('view_details.referrer_page') }}">
                <x-slot:icon>
                    <span>
                        <i class="bi bi-ui-checks-grid"></i>
                    </span>
                </x-slot:icon>
            </x-user.sidebar-menu-item>
            @endif

            <x-user.sidebar-menu-item label="Dashboard" pattern="{{ routeName('user.dashboard') }}">
                <x-slot:icon>
                    <span><i class="bi bi-speedometer2"></i></span>
                </x-slot:icon>
            </x-user.sidebar-menu-item>

            <x-user.sidebar-menu-item label="Transaction" pattern="{{ routeName('user.transactions') }}">
                <x-slot:icon>
                    <span><i class="bi bi-credit-card-fill"></i></span>
                </x-slot:icon>
            </x-user.sidebar-menu-item>

            <x-user.sidebar-menu-item label="Reward Badges" pattern="{{ routeName('user.investment-rewards') }}">
                <x-slot:icon>
                    <span><i class="bi bi-award-fill"></i></span>
                </x-slot:icon>
            </x-user.sidebar-menu-item>

            @php
            $matrixPattern = [routePattern('user.matrix'), routePattern('user.referral-rewards'),
            routePattern('user.commissions')]
            @endphp

            <x-user.sidebar-menu-item :pattern="$matrixPattern" label="Matrix" href="collapseWithdraw">
                <x-slot:icon>
                    <span><i class="bi la-money-bill-wave"></i></span>
                </x-slot:icon>
                <x-slot:dropdown>
                    <ul class="sub-menu">
                        <x-user.sub-menu-item label="Scheme" pattern="{{ routeName('user.matrix') }}" />
                        <x-user.sub-menu-item label="Referral Rewards"
                            pattern="{{ routeName('user.referral-rewards') }}" />
                        <x-user.sub-menu-item label="Commissions" pattern="{{ routeName('user.commissions') }}" />
                    </ul>
                </x-slot:dropdown>
            </x-user.sidebar-menu-item>

            <x-user.sidebar-menu-item label="Investments" href="collapsePaymentProcessor"
                pattern="{{ routePattern('user.investment') . '*' }}">
                <x-slot:icon>
                    <span>
                        <i class="bi bi-wallet-fill"></i>
                    </span>
                </x-slot:icon>
                <x-slot:dropdown>
                    <ul class="sub-menu">
                        <x-user.sub-menu-item label="Scheme" pattern="{{ routeName('user.investment') }}" />
                        <x-user.sub-menu-item label="Active" pattern="{{ routeName('user.active-investments') }}" />
                        <x-user.sub-menu-item label="History" pattern="{{ routeName('user.investment-records') }}" />
                        <x-user.sub-menu-item label="Profit Statistics"
                            pattern="{{ routeName('user.profit-statistics') }}" />
                        <x-user.sub-menu-item label="Goal Calculator"
                            pattern="{{ routeName('user.investment-goal-calculator') }}" />
                    </ul>
                </x-slot:dropdown>
            </x-user.sidebar-menu-item>

            <x-user.sidebar-menu-item label="Staking Investment" pattern="{{ routeName('user.staking-investment') }}">
                <x-slot:icon>
                    <span><i class="bi bi-currency-euro"></i></span>
                </x-slot:icon>
            </x-user.sidebar-menu-item>

            <x-user.sidebar-menu-item label="Trades" href="collapseTrade"
                pattern="{{ routePattern('user.trade') . '*' }}">
                <x-slot:icon>
                    <span><i class="bi bi-bar-chart"></i></span>
                </x-slot:icon>
                <x-slot:dropdown>
                    <ul class="sub-menu">
                        <x-user.sub-menu-item label="Trade Now" pattern="{{ routeName('user.trade') }}" />
                        <x-user.sub-menu-item label="History" pattern="{{ routeName('user.trade-records') }}" />
                        <x-user.sub-menu-item label="Practices"
                            pattern="{{ routeName('user.trade-practice-history') }}" />
                    </ul>
                </x-slot:dropdown>
            </x-user.sidebar-menu-item>

            <x-user.sidebar-menu-item label="Deposit" href="collapseDeposit"
                pattern="{{ routePattern('user.deposit') . '*' }}">
                <x-slot:icon>
                    <span><i class="bi bi-wallet2"></i></span>
                </x-slot:icon>
                <x-slot:dropdown>
                    <ul class="sub-menu">
                        <x-user.sub-menu-item label="Instant" pattern="{{ routeName('user.deposit') }}" />
                        <x-user.sub-menu-item label="Commissions"
                            pattern="{{ routeName('user.deposit-commissions') }}" />
                    </ul>
                </x-slot:dropdown>
            </x-user.sidebar-menu-item>

            <x-user.sidebar-menu-item label="Referrals" pattern="{{ routeName('user.referrals') }}">
                <x-slot:icon>
                    <span><i class="bi bi-command"></i></span>
                </x-slot:icon>
            </x-user.sidebar-menu-item>

            <x-user.sidebar-menu-item label="Cashout" pattern="{{ routeName('user.cash-out') }}">
                <x-slot:icon>
                    <span><i class="bi bi-wallet"></i></span>
                </x-slot:icon>
            </x-user.sidebar-menu-item>



            <li class="sidebar-menu-item">
                <a @class(['sidebar-menu-link', 'active'=> request()->routeIs('user.insta-pin-recharge')]) href="{{
                    route('user.insta-pin-recharge') }}" aria-expanded="false">
                    <span><i class="bi bi-cash"></i></span>
                    <p>InstaPIN Recharge</p>
                </a>
            </li>

            <x-user.sidebar-menu-item label="Settings" pattern="{{ routeName('user.settings') }}">
                <x-slot:icon>
                    <span><i class="bi bi-gear"></i></span>
                </x-slot:icon>
            </x-user.sidebar-menu-item>
        </ul>
    </div>
</div>