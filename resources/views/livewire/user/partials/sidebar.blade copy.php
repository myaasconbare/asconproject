<div class="d-sidebar" id="user-sidebar">
    <div class="sidebar-logo">
        <a href="{{ route('guest.home') }}">
            <img src="{{ asset('files/CvuUr9CwYsyU6VVB.png') }}" alt="logo" />
        </a>
    </div>
    <div class="main-nav sidebar-menu-container">
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.dashboard')]) href="{{ route('user.dashboard') }}" aria-expanded="false">
                    <span><i class="bi bi-speedometer2"></i></span>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link" href="{{ route('user.transactions') }}" aria-expanded="false">
                    <span><i class="bi bi-credit-card-fill"></i></span>
                    <p>Transaction</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link" href="{{ route('user.investment-rewards') }}" aria-expanded="false">
                    <span><i class="bi bi-award-fill"></i></span>
                    <p>Reward Badges</p>
                </a>
            </li>

            @php
                $matrixPattern = [routePattern('user.matrix'), routePattern('user.referral-rewards'), routePattern('user.commissions')];
                $isInMatrixSection = request()->is($matrixPattern);
            @endphp

            <li class="sidebar-menu-item">
                <a @class(['sidebar-menu-link', 'active' => $isInMatrixSection]) class="sidebar-menu-link collapsed" data-bs-toggle="collapse" href="#collapseWithdraw" role="button" aria-expanded="false" aria-controls="collapseWithdraw">
                    <span><i class="bi la-money-bill-wave"></i></span>
                    <p>
                        Matrix<small><i class="las la-angle-down"></i></small>
                    </p>
                </a>
                <div @class(['side-menu-dropdown collapse', 'show' => $isInMatrixSection]) id="collapseWithdraw">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a  @class(['sidebar-menu-link', 'active' => request()->routeIs('user.matrix')]) href="{{ route('user.matrix') }}" aria-expanded="false">
                                <p>Scheme</p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a  @class(['sidebar-menu-link', 'active' => request()->routeIs('user.referral-rewards')]) href="{{ route('user.referral-rewards') }}" aria-expanded="false">
                                <p>Referral Rewards</p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a  @class(['sidebar-menu-link', 'active' => request()->routeIs('user.commissions')]) href="{{ route('user.commissions') }}" aria-expanded="false">
                                <p>Commissions</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php
                $investmentPattern = routePattern('user.investment') . '*';
                $isInInvestmentSection = request()->is($investmentPattern);
            @endphp

            <li class="sidebar-menu-item">
                <a  @class(['sidebar-menu-link', 'active' => $isInInvestmentSection]) data-bs-toggle="collapse" href="#collapsePaymentProcessor" role="button" aria-expanded="{{ $isInInvestmentSection ? true : false }}" aria-controls="collapsePaymentProcessor">
                    <span><i class="bi bi-wallet-fill"></i></span>
                    <p>
                        Investments <small><i class="las la-angle-down"></i></small>
                    </p>
                </a>
                <div @class(['side-menu-dropdown collapse', 'show' => $isInInvestmentSection]) id="collapsePaymentProcessor">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.investment')]) href="{{ route('user.investment') }}" aria-expanded="false">
                                <p>Scheme</p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.investment-records')]) href="{{ route('user.investment-records') }}" aria-expanded="false">
                                <p>Funds</p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.profit-statistics')]) href="{{ route('user.profit-statistics') }}" aria-expanded="false">
                                <p>Profit Statistics</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-item">
                <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.staking-investment')]) href="{{ route('user.staking-investment') }}" aria-expanded="false">
                    <span><i class="bi bi-currency-euro"></i></span>
                    <p>Staking Investment</p>
                </a>
            </li>

            @php
                $tradePattern = routePattern('user.trade') . '*';
                $isInTradeSection = request()->is($tradePattern);
            @endphp

            <li class="sidebar-menu-item">
                <a @class(['sidebar-menu-link', 'active' => $isInTradeSection])  data-bs-toggle="collapse" href="#collapseTrade" role="button" aria-expanded="false" aria-controls="collapseTrade">
                    <span><i class="bi bi-bar-chart"></i></span>
                    <p>
                        Trades <small><i class="las la-angle-down"></i></small>
                    </p>
                </a>
                <div @class(['side-menu-dropdown collapse', 'show' => $isInTradeSection]) id="collapseTrade">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.trade')]) href="{{ route('user.trade') }}" aria-expanded="false">
                                <p>Trade Now</p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.trade-records')]) href="{{ route('user.trade-records') }}" aria-expanded="false">
                                <p>History</p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.trade-practice')]) href="{{ route('user.trade-practice') }}" aria-expanded="false">
                                <p>Practices</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed" data-bs-toggle="collapse" href="#collapseDeposit" role="button" aria-expanded="false" aria-controls="collapseTrade">
                    <span><i class="bi bi-wallet2"></i></span>
                    <p>
                        Deposit <small><i class="las la-angle-down"></i></small>
                    </p>
                </a>
                <div class="side-menu-dropdown collapse" id="collapseDeposit">
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.deposit')]) href="{{ route('user.deposit') }}" aria-expanded="false">
                                <p>Instant</p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.deposit-commissions')]) href="{{ route('user.deposit-commissions') }}" aria-expanded="false">
                                <p>Commissions</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-item">
                <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.referrals')]) href="{{ route('user.referrals') }}" aria-expanded="false">
                    <span><i class="bi bi-command"></i></span>
                    <p>Referrals</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.cash-out')]) href="{{ route('user.cash-out') }}" aria-expanded="false">
                    <span><i class="bi bi-wallet"></i></span>
                    <p>Cash out</p>
                </a>
            </li>

            {{-- <li class="sidebar-menu-item">
                <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.investment')]) href="/users/insta-pin-recharge" aria-expanded="false">
                    <span><i class="bi bi-cash"></i></span>
                    <p>InstaPIN Recharge</p>
                </a>
            </li> --}}

            <li class="sidebar-menu-item">
                <a @class(['sidebar-menu-link', 'active' => request()->routeIs('user.settings')]) href="{{ route('user.settings') }}" aria-expanded="false">
                    <span><i class="bi bi-gear"></i></span>
                    <p>Settings</p>
                </a>
            </li>
        </ul>
    </div>
</div>