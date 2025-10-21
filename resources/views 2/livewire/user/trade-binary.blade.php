<div x-data="trade"  class="trading-section pt-5 pb-110">
    <div class="container i-container">
        <div class="row g-4">
            <div wire:ignore class="col-xl-9">
                <div class="market-graph">
                    <div class="mb-5">
                        <div class="tradingview-widget-container p-2">
                            <div class="tradingview-widget-container__widget"></div>
                            <script type="text/javascript"
                                src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js"
                                async="">
                                {
                                    "autosize": true,
                                    "width": "100%",
                                    "height": 500,
                                    "symbol": "BITSTAMP:{{ strtoupper($this->currency->symbol) }}usd",
                                    "interval": "1",
                                    "timezone": "Etc/UTC",
                                    "theme": "light",
                                    "style": "1",
                                    "locale": "en",
                                    "enable_publishing": true,
                                    "hide_legend": true,
                                    "withdateranges": true,
                                    "hide_side_toolbar": false,
                                    "allow_symbol_change": true,
                                    "details": true,
                                    "hotlist": true,
                                    "calendar": false,
                                    "support_host": "https://www.tradingview.com"
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                    <div class="card--title mb-0">
                        <h5 class="mb-0">Rise/Fall</h5>
                    </div>
                    <a href="{{ route('user.dashboard') }}" class="i-btn btn--primary btn--md capsuled"><i
                            class="bi bi-chevron-left me-1"></i>Dashboard</a>
                </div>
                <div wire:ignore class="market-widget mb-4">
                    {{-- <form method="POST"> --}}
                        {{-- @csrf --}}
                       
                        <div class="input-single">
                            <label for="amount">Amount</label>
                            <input x-model="amount" type="text" id="amount" name="amount" value="" placeholder="0.00" required="" />
                        </div>

                        <div class="input-single">
                            <label for="parameter">Expiry Time</label>
                            <select wire:model='duration' type="text" id="parameter" name="parameter_id" required="">
                                <option value="">Select Expiration Time</option>
                                @foreach ($tradeDurations as $tradeDuration)                                
                                    <option value="{{ $tradeDuration->id }}">Time: {{ $tradeDuration->duration }} {{ $tradeDuration->period_label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="profit-card">
                            <div class="percent">
                                <span x-ref="profitAmount" id="profit_amount">+0.00</span>
                                <sub> / {{ $commissionPercentage }} %</sub>
                            </div>
                            <p>Profit</p>
                        </div>
                        <div class="d-flex justify-content-center align-items-center gap-3">
                            <button x-ref="tradeHigh" wire:click.prevent="trade('high')" type="button" name="volume"
                                class="i-btn btn--md btn--success capsuled w-100 spin-btn">
                                <x-spinner wire:loading.class='d-flex' wire:target="trade('high')"/> 
                                
                                High <i class="bi bi-arrow-up"></i>
                            </button>
                            <button x-ref="tradeLow" wire:click.prevent="trade('low')" type="button" name="volume" 
                                class="i-btn btn--md btn--danger capsuled w-100 spin-btn">
                                <x-spinner wire:loading.class='d-flex' wire:target="trade('low')"/> 
                                Low <i class="bi bi-arrow-down"></i>
                            </button>
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
            <div class="col-xl-12">
                <div class="scroll-design">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Initiated At</th>
                                    <th>Amount</th>
                                    <th>Volume</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Outcome</th>
                                </tr>
                            </thead>
                           <tbody wire:poll.1s='refreshTrades'>
                            @foreach ($trades as $trade)     
                            <tr>
                                <td data-label="Initiated At">
                                    {{ $trade->created_at->diffForHumans() }}
                                </td>
                                <td data-label="Amount">
                                    {{ $trade->amount_label }}
                                </td>
                                <td data-label="Volume">
                                    <span class="i-badge badge--{{ $trade->volume == 1 ? 'success' : 'danger' }}">
                                        {{ $trade->volume == 1 ? 'High' : 'Low' }}
                                    </span>
                                </td>
                                <td data-label="Price">
                                    {{ \Illuminate\Support\Number::currency($trade->original_price) }}
                                </td>
                                <td data-label="Type">
                                    <span class="i-badge badge--primary text-uppercase">
                                        {{ $trade->type }}
                                    </span>
                                </td>
                                <td data-label="Outcome">
                                    <span class="i-badge badge--{{ $trade->outcome_color }}">
                                        {{ $trade->outcome }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                           </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


  @script
    <script>
        Alpine.data('trade', () => ({
            amount: $wire.entangle('amount'),
            setProfitAmount(amount){
                const inputAmount = parseFloat(amount);
                const commissionPercentage = @js($commissionPercentage);

                if (isNaN(inputAmount)) {
                    this.$refs.profitAmount.textContent = ("+" + 0.0);
                    return;
                }

                const profit = (commissionPercentage / 100) * inputAmount;
                const withProfitAmount = parseFloat(inputAmount) + parseFloat(profit);

                this.$refs.profitAmount.textContent = ("+" + withProfitAmount.toFixed(2));
            },
            init(){
                this.$watch('amount', this.setProfitAmount.bind(this));

                $wire.on('server-message', $store.utils.handleServerMsg.bind($store.utils));
            }
        }));
    </script>
@endscript

