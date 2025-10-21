<div>
    <div class="main-content" data-simplebar="">
        <div x-data="trades" class="row">
            <div class="col-lg-12">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="i-card-sm mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="title my-0">Trade logs</h5>
                                <button data-bs-toggle="modal" data-bs-target="#topUpModal" type="submit" class="i-btn btn--sm btn--primary">
                                    Top Up Practice Balance
                                </button>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="i-card-sm bg--dark shadow-none flex-grow-1 py-3 px-4 rounded-3">
                                    <span class="inline-block lh-1 text--light">Trade Balance</span>
                                    <h5 class="mt-2">
                                        {{ money(auth()->user()->trade_wallet) }}
                                    </h5>
                                </div>
                                <div class="i-card-sm bg--dark shadow-none flex-grow-1 py-3 px-4 rounded-3">
                                    <span class="inline-block lh-1 text--light">Practice Balance</span>
                                    <h5 class="mt-2">
                                        {{ money(auth()->user()->trade_practice_wallet) }}
                                    </h5>
                                </div>
                            </div>
    
                            <ul class="d-flex flex-column gap-2">
                                <li class="p-3 d-flex bg--dark">
                                    <div class="flex-grow-1 d-flex align-items-center gap-3">
                                        <h5 class="text--light fs-14">Total Trade Amount</h5>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="text-white fw-bold fs-14">
                                            {{ $totalTradeAmount }}
                                        </h5>
                                    </div>
                                </li>
                                <li class="p-3 d-flex bg--dark">
                                    <div class="flex-grow-1 d-flex align-items-center gap-3">
                                        <h5 class="text--light fs-14">Today Trading</h5>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="text-white fw-bold fs-14">
                                            {{ $todayTrading }}
                                        </h5>
                                    </div>
                                </li>
                                <li class="p-3 d-flex bg--dark">
                                    <div class="flex-grow-1 d-flex align-items-center gap-3">
                                        <h5 class="text--light fs-14">Wining Amount</h5>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="text-white fw-bold fs-14">
                                            {{ $winningAmount }}
                                        </h5>
                                    </div>
                                </li>
                                <li class="p-3 d-flex bg--dark">
                                    <div class="flex-grow-1 d-flex align-items-center gap-3">
                                        <h5 class="text--light fs-14">Loss Amount</h5>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="text-white fw-bold fs-14">
                                            {{ $lossAmount }}
                                        </h5>
                                    </div>
                                </li>
                                <li class="p-3 d-flex bg--dark">
                                    <div class="flex-grow-1 d-flex align-items-center gap-3">
                                        <h5 class="text--light fs-14">Draw Amount</h5>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="text-white fw-bold fs-14">
                                            {{ $drawAmount }}
                                        </h5>
                                    </div>
                                </li>
                                <li class="p-3 d-flex bg--dark">
                                    <div class="flex-grow-1 d-flex align-items-center gap-3">
                                        <h5 class="text--light fs-14">High Amount</h5>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="text-white fw-bold fs-14">
                                            {{ $highAmount }}
                                        </h5>
                                    </div>
                                </li>
                                <li class="p-3 d-flex bg--dark">
                                    <div class="flex-grow-1 d-flex align-items-center gap-3">
                                        <h5 class="text--light fs-14">Low Amount</h5>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="text-white fw-bold fs-14">
                                            {{ $lowAmount }}
                                        </h5>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="i-card-sm">
                            <div wire:ignore id="totalTrade"></div>
                        </div>
                    </div>
                </div>
    
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title">Trade logs</h4>
                    </div>
                    <div class="filter-area">
                        <form>
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                <div class="col">
                                    <select class="select2-js" name="outcome">
                                        <option selected value>ALL</option>
                                        <option @selected($outcome == 'initiated') value="initiated">INITIATED</option>
                                        <option @selected($outcome == 'win') value="win">WIN</option>
                                        <option @selected($outcome == 'lose') value="lose">LOSE</option>
                                        <option @selected($outcome == 'draw') value="draw">DRAW</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select wire:model='volume' class="select2-js" name="volume">
                                        <option selected value>ALL</option>
                                        <option @selected($volume == '1') value="1">HIGH</option>
                                        <option @selected($volume == '0') value="0">LOW</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" wire:model='date' id="date" class="form-control datepicker-here" name="date"
                                        value="" data-range="true" data-multiple-dates-separator=" - "
                                        data-language="en" data-position="bottom right" autocomplete="off"
                                        placeholder="Date">
                                </div>
                                <div class="col">
                                    <button type="submit" class="i-btn btn--lg btn--primary w-100"><i
                                            class="bi bi-search me-3"></i>Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
    
                    <div class="table-container">
                        <table id="myTable" class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Initiated At</th>
                                    <th scope="col">Crypto</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Arrival Time</th>
                                    <th scope="col">Volume</th>
                                    <th scope="col">Outcome</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trades as $trade)
                                <tr>
                                    <td data-label="Initiated At">
                                        {{ formatDate($trade->created_at) }}
                                    </td>
                                    <td data-label="Crypto">
                                        {{ $trade->cryptoCurrency->name }}
                                    </td>
                                    <td data-label="Price">
                                        {{ money($trade->original_price) }}
                                    </td>
                                    <td data-label="Amount">
                                        @if ($trade->is_win)   
                                            {{ money($trade->amount) }} + {{ money($trade->winning_amount) }} = 
                                            <span class="text--success">
                                                {{ money($trade->profit) }}
                                            </span>
                                        @elseif($trade->is_draw)
                                            <span class="text--primary">
                                                {{ money($trade->amount) }}
                                            </span>
                                        @else
                                            <span class="text--danger">
                                                {{ money($trade->amount) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td data-label="Arrival Time">
                                        {{ formatDate($trade->arrival_time) }}
                                    </td>
                                    <td data-label="Volume">
                                        <span class="i-badge badge--danger text-apitalize">
                                            {{ strtolower($trade->volume_label) }}
                                        </span>
                                    </td>
                                    <td data-label="Outcome">
                                        <span class="i-badge text-apitalize badge--{{ $trade->outcome_color }}">
                                            {{ $trade->outcome }}
                                        </span>
                                    </td>
                                    <td data-label="Status">
                                        <span class="i-badge badge--{{ $trade->status_color }}">
                                            {{ $trade->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
    
                    {{ $trades->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
               
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore class="modal fade" id="topUpModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title" id="methodTitle">
                        Top Up Practice Wallet
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit='topUpSubmit' method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="text-end">
                            <p class="mb-0" id="withdraw_limit"></p>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="col-form-label">Amount</label>
                            <div class="input-group mb-3">
                                <input wire:model='amount' type="text" class="form-control" id="amount" name="amount"
                                    placeholder="Enter Amount" aria-label="Recipient's username"
                                    aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">USD</span>
                            </div>
                        </div>           
                    </div>
    
                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--outline btn--sm"
                            data-bs-dismiss="modal"> 
                            Close
                        </button>
                        <button type="submit" class="i-btn btn--primary btn--sm spin-btn-xs">
                            <x-spinner wire:loading.class='d-flex' wire:target='topUpSubmit'/> 
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@script
<script>
    Alpine.data('trades', () => ({
        init(){
                $wire.on('server-message', (response) => {
                    $store.utils.handleServerMsg(response);
                    if(response[0].type == 'success'){
                        $('#topUpModal').modal('hide');
                    }
                });
            }
    }));
</script>
@endscript

@script
<script>
    "use strict";

    $(document).ready(function () {
        const amount = @js($this->tradeDailyStats['tradedAmounts']);
        const days = @js($this->tradeDailyStats['days']);
        const currency = "$";
        const content = "Trade Reports Over the Last 90 Days";
        const tradeContent = "Trade Amount";

        const options = {
            series: [{
                name: tradeContent,
                data: amount
            }],
            chart: {
                type: 'bar',
                height: 535,
                toolbar: false,
                foreColor: '#ffffff'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: days,
                labels: {
                    style: {
                        colors: '#ffffff'
                    }
                }
            },
            yaxis: {
                title: {
                    text: content,
                    style: {
                        color: '#ffffff'
                    }
                },
                labels: {
                    style: {
                        colors: '#ffffff'
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return currency + val;
                    },
                    style: {
                        color: '#ffffff'
                    }
                }
            }
        };
        const chart = new ApexCharts(document.querySelector("#totalTrade"), options);
        chart.render();
    });

</script>
@endscript