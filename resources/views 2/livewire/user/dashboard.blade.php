<div class="main-content" data-simplebar="">
    <div id="tsparticles"></div>


    @if(request()->missing('search'))
    <div class="row">
        <div class="col-md-6">
            <div class="i-card-sm mb-4 p-3">
                <label for="referral-url" class="form-label">Referral URL</label>
                <div class="input-group">
                    <input
                        type="text"
                        id="referral-url"
                        class="form-control reference-url"
                        value="{{ auth()->user()->referral_url }}"
                        aria-label="Recipient's username"
                        aria-describedby="reference-copy"
                        readonly=""
                    />
                    <span class="input-group-text bg--primary text-white" id="reference-copy">Copy<i class="las la-copy ms-2"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="i-card-sm mb-4 p-3">
                <label for="user-uid" class="form-label">UID</label>
                <div class="input-group">
                    <input type="text" id="user-uid" class="form-control user-uid" value="{{ auth()->id() }}" aria-label="Recipient's username" aria-describedby="user-uid-copy" readonly="" />
                    <span class="input-group-text bg--primary text-white" id="user-uid-copy">Copy<i class="las la-copy ms-2"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="i-card-sm mb-4">
        <div class="row g-4">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="i-card-sm card-style rounded-3">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="title text--purple mb-4">Investment</h5>
                        <div class="avatar--lg bg--pink">
                            <i class="bi bi-credit-card text-white"></i>
                        </div>
                    </div>

                    <div class="card-info text-center">
                        <ul class="user-card-list w-100">
                            <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                <span class="fw-bold">Total Invest</span>
                                <span class="fw-bold text--dark">
                                    {{ money(auth()->user()->total_invested) }}
                                </span>
                            </li>
                            <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                <span class="fw-bold">Total Profits</span>
                                <span class="fw-bold text--dark">
                                    {{ money(auth()->user()->total_profits) }}
                                </span>
                            </li>
                            <li class="d-flex align-items-center justify-content-between gap-3">
                                <span class="fw-bold">Running Invest</span>
                                <span class="fw-bold text--dark">
                                    {{ money($runningInvestments) }}
                                </span>
                            </li>
                        </ul>
                        <a href="{{ route('user.investment') }}" class="btn--white">
                            Investment Now
                            <i class="bi bi-box-arrow-up-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="i-card-sm card-style rounded-3">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="title text--blue mb-4">Matrix</h5>
                        <div class="avatar--lg bg--blue">
                            <i class="bi bi-wallet text-white"></i>
                        </div>
                    </div>
                    <div class="card-info text-center">
                        <ul class="user-card-list mb-4 w -100">
                            <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                <span class="fw-bold">Total Commission</span>
                                <span class="fw-bold text--dark">
                                    {{ money(auth()->user()->matrix_commission) }}
                                </span>
                            </li>
                            <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                <span class="fw-bold">Referral Commission</span>
                                <span class="fw-bold text--dark">
                                    {{ money(auth()->user()->matrix_referral_commission) }}
                                </span>
                            </li>
                            <li class="d-flex align-items-center justify-content-between gap-3">
                                <span class="fw-bold">Level Commission</span>
                                <span class="fw-bold text--dark">
                                    {{ money(auth()->user()->matrix_level_commission) }}
                                </span>
                            </li>
                        </ul>
                        <a href="{{ route('user.matrix') }}" class="btn--white">
                            Enrolled<i class="bi bi-box-arrow-up-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="i-card-sm card-style rounded-3">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="title mb-0 text--yellow">Trade</h5>
                        <div class="avatar--lg bg--yellow">
                            <i class="bi bi-bar-chart text-white"></i>
                        </div>
                    </div>

                    <div class="card-info text-center">
                        <ul class="user-card-list w-100">
                            <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                <span class="fw-bold">Total Trading</span>
                                <span class="fw-bold text--dark">
                                    {{ money(auth()->user()->total_trading) }}
                                </span>
                            </li>
                            <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                <span class="fw-bold">Wining Amount</span>
                                <span class="fw-bold text--dark">
                                    {{ money(auth()->user()->winning_amount) }}
                                </span>
                            </li>
                            <li class="d-flex align-items-center justify-content-between gap-3">
                                <span class="fw-bold">Loss Amount</span>
                                <span class="fw-bold text--dark">
                                    {{ money(auth()->user()->loss_amount) }}
                                </span>
                            </li>
                        </ul>
                        <a href="{{ route('user.trade') }}" class="btn--white">
                            Start Trading <i class="bi bi-box-arrow-up-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="i-card-sm">
                <h5 class="title mb-4">Monthly deposit &amp; withdraw statistics</h5>
                <div wire:ignore id="monthlyChart"></div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="i-card-sm">
                <div class="row g-4">
                    <div class="col-xl-12 col-md-6">
                        <div class="i-card-sm style-border-blue blue border rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="title danger mb-0">Deposit Statistics</h5>
                                <div class="avatar--lg bg--blue">
                                    <i class="bi bi-wallet text-white"></i>
                                </div>
                            </div>
                            <div class="card-info text-center">
                                <ul class="user-card-list w -100">
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                        <span class="fw-bold">Total Deposit</span>
                                        <span class="fw-bold text--dark">
                                            {{ money(auth()->user()->total_deposited) }}
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                        <span class="fw-bold">Primary Account</span>
                                        <span class="fw-bold text--dark">$4751</span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                        <span class="fw-bold">Investment Account</span>
                                        <span class="fw-bold text--dark">$0</span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3">
                                        <span class="fw-bold">Trade Account</span>
                                        <span class="fw-bold text--dark">$900</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6">
                        <div class="i-card-sm style-border-green green border rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="title mb-0">Withdraw Statistics</h5>
                                <div class="avatar--lg bg--green">
                                    <i class="bi bi-credit-card text-white"></i>
                                </div>
                            </div>

                            <div class="card-info text-center">
                                <ul class="user-card-list w-100">
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                        <span class="fw-bold">Total Withdraw</span>
                                        <span class="fw-bold text--dark">
                                            {{ money(auth()->user()->total_withdrawn) }}
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                        <span class="fw-bold">Withdraw Charge</span>
                                        <span class="fw-bold text--dark">
                                            {{ money($withdrawCharge) }}
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                        <span class="fw-bold">
                                            Pending Withdraw
                                        </span>
                                        <span class="fw-bold text--dark">
                                            {{ money($pendingWithdrawal) }}
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                        <span class="fw-bold">Rejected Withdraw</span>
                                        <span class="fw-bold text--dark">
                                            {{ money($declinedWithdrawal) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="i-card-sm">
                <div class="card-info">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="title">Commissions</h5>
                        <a class="arrow--btn" href="{{ route('user.referrals') }}">Referral Program <i class="bi bi-arrow-right-short"></i></a>
                    </div>
                    <div class="card-info" wire:poll.30s class="total-balance-wrapper">
                        <div class="total-balance">
                            <p>Investment Commission</p>
                            <div class="d-flex gap-2">
                                <h4>
                                    {{ money(auth()->user()->investment_commission) }}
                                </h4>
                            </div>
                        </div>
                        <div class="total-balance">
                            <p>Referral Commission</p>
                            <div class="d-flex gap-2">
                                <h4>
                                    {{ money(auth()->user()->referral_commission) }}
                                </h4>
                            </div>
                        </div>
                        <div class="total-balance">
                            <p>Level Commission</p>
                            <div class="d-flex gap-2">
                                <h4>
                                    {{ money(auth()->user()->level_commission) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="i-card-sm">
                <div class="card-info" wire:poll.30s>
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="title">Wallets</h5>
                        <a class="arrow--btn" href="{{ route('user.wallet-top-up') }}">
                            Wallet Top Up <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                    <div class="total-balance-wrapper">
                        <div class="total-balance">
                            <p>Deposit Wallet</p>
                            <div class="d-flex gap-2">
                                <h4>
                                    {{ money(auth()->user()->deposit_wallet) }}
                                </h4>
                            </div>
                        </div>
                        <div class="total-balance">
                            <p>Interest Wallet</p>
                            <div class="d-flex gap-2">
                                <h4>
                                    {{ money(auth()->user()->interest_wallet) }}
                                </h4>
                            </div>
                        </div>
                        <div class="total-balance">
                            <p>Residual Wallet</p>
                            <div class="d-flex gap-2">
                                <h4>
                                    {{ money(auth()->user()->residual_wallet) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <livewire:user.partials.transactions
        title="Latest Transactions"
        limit="10"
    />
</div>

@script
<script>
    "use strict";
    $(document).ready(function () {
        const depositMonthAmount = @js($this->transactionMonthlyStats['depositAmounts']);
        const withdrawMonthAmount = @js($this->transactionMonthlyStats['withdrawalAmounts']);
        const months = @js($this->transactionMonthlyStats['months']);
        const currency = "$";

        const options = {
            series: [
                {
                    name: "Total Deposits Amount",
                    data: depositMonthAmount,
                },
                {
                    name: "Total Withdraw Amount",
                    data: withdrawMonthAmount,
                },
            ],
            chart: {
                height: 530,
                type: "line",
                toolbar: false,
                zoom: {
                    enabled: false,
                },
            },
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    dataLabels: {
                        position: "bottom",
                    },
                },
            },
            dataLabels: {
                enabled: true,
                formatter: function (val, opts) {
                    return "";
                },
                offsetY: -20,
                style: {
                    fontSize: "12px",
                    colors: ["#304758"],
                },
            },
            xaxis: {
                categories: months,
                position: "top",
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
                crosshairs: {
                    fill: {
                        type: "gradient",
                        gradient: {
                            colorFrom: "#D8E3F0",
                            colorTo: "#BED1E6",
                            stops: [0, 100],
                            opacityFrom: 0.4,
                            opacityTo: 0.5,
                        },
                    },
                },
                tooltip: {
                    enabled: true,
                },
                labels: {
                    style: {
                        colors: "#ffffff",
                    },
                },
            },
            yaxis: {
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function (val) {
                        return currency + val;
                    },
                    style: {
                        colors: "#ffffff",
                    },
                },
            },
            title: {
                floating: true,
                offsetY: 340,
                align: "center",
                style: {
                    color: "#222",
                    fontWeight: 600,
                },
            },
        };

        const chart = new ApexCharts(document.querySelector("#monthlyChart"), options);
        chart.render();

        $("#reference-copy").click(function () {
            const copyText = $(".reference-url");
            copyText.select();
            document.execCommand("copy");
            copyText.blur();
            notify("success", "Copied to clipboard!");
        });

        $("#user-uid-copy").click(function () {
            const copyTextUID = $(".user-uid");
            copyTextUID.select();
            document.execCommand("copy");
            copyTextUID.blur();
            notify("success", "Copied to clipboard!");
        });
    });
</script>
@endscript