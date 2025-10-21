@assets
<style>
    .days-input:focus-within {
        border: 1px solid var(--color-primary);
    }
    .days-input input {
        border: 0px;
        border-right: 1px solid var(--color-border);
    }

    .days-input input::placeholder{
        color: var(--text-secondary);
    }
    .days-input:focus-within input {
        border: 0px;
        border-right: 1px solid var(--color-primary);
    }
</style>
@endassets

<div x-data="calculator" class="main-content" data-simplebar="">
    <h3 class="page-title">
        Investment Goal Calculator
    </h3>
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="i-card-sm mb-4 ">
                <div class="card-header">
                    <h4 class="fs-17 border--left mb-4">
                        See how your investment can help you reach your goals
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row align-items-center gy-4">
                        <div class="user-form">
                            <form x-on:submit.prevent="showResult"  method="POST">
                                <div class="col-lg-12">
                                    <div class="form-inner">
                                        <label for="duration" class="text-uppercase">
                                            How long do you want to invest?
                                        </label>
                                        <div class="input-group days-input form-control p-0">
                                            <input x-model="duration" placeholder="Enter duration" type="text" id="duration"
                                                class="form-control  b-0" />
                                            <span class="input-group-text bg-transparent text-white"
                                                id="reference-copy">
                                                DAYS
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-inner">
                                        <label for="amount" class="text-uppercase">How much do you want to
                                            invest?</label>
                                        <input x-model="amount" type="number" id="amount" name="amount" placeholder="Enter Amount"
                                            required="" />
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-inner">
                                        <label for="account" class="text-uppercase">select preferred license</label>
                                        <select x-ref="license" x-model='license' id="account" name="account" required="">
                                            <option value="">Select One</option>
                                            @foreach ($portfolios as $portfolio)
                                                @foreach ($portfolio->licenses as $license)
                                                <option 
                                                    data-rate="{{ $license->rate }}" 
                                                    data-min_rate="{{ $license->minimum_interest_rate }}"
                                                    data-max_rate="{{ $license->maximum_interest_rate }}" 
                                                    data-is_unlimited="{{ $license->is_unlimited }}"
                                                    data-max_amount="{{ $license->maximum_amount }}"
                                                    data-min_amount="{{ $license->minimum_amount }}" 
                                                    value="{{ $license->id }}"
                                                >
                                                    {{ $license->portfolio->name }} : {{ $license->minimum_interest_rate }}%
                                                    - {{ $license->maximum_interest_rate }}%
                                                </option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="i-btn btn--primary btn--lg">
                                            Calculate
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="i-card-sm mb-4 h-full" style="height:100%">
                <div class="card-header">
                    <h4 class="fs-17 border--left mb-4">
                        <br>
                        {{-- Transfer balance from one account to the other --}}
                    </h4>
                </div>
                <div class="card-body text-center">
                    <div class="row align-items-center gy-4">
                        <div class="user-form">
                            <h4>
                                Total Investment Fund
                            </h2>
                            <h1 x-text="format(amount)"></h1>
                            <div class="price-info">
                                <h6 class="mb-1">Profit Range: <span x-text='profitRange'></span></h6>
                                {{-- <h6 class="mb-2">Aggregate Level Commission: $324</h6> --}}
                                <p class="mb-0" x-show="result">
                                    
                                    <span x-text="result">
                                        324%
                                    </span>
                                   
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@script
<script>
    Alpine.data('calculator', () => ({
        result: null,
        duration :null,
        amount :null,
        license :null,
        profitRange: '$0.00 - $0.00',
        selectedLicenseData : null,
        showResult(){
            if(!this.amount) return notifyError("Please enter Investment amount");
            if(!this.selectedLicenseData) return notifyError("Please select a license");
            if(!this.duration) return notifyError("Duration can't be empty!");

            if(
                +this.amount < +this.selectedLicenseData.min_amount || 
                !this.selectedLicenseData.is_unlimited && +this.amount > +this.selectedLicenseData.max_amount
            ) {
                let rangeStart = money(this.selectedLicenseData.min_amount);
                let rangeEnd = this.selectedLicenseData.is_unlimited ? 'UNLIMITED' : money(this.selectedLicenseData.max_amount);
                
                return notifyError(`Amount is out of range for the selected license ${rangeStart} - ${rangeEnd}`)
            }

            let minimumProfit  =  ((this.selectedLicenseData.min_rate / 100) * this.amount) * this.duration;
            let maximumProfit  =  ((this.selectedLicenseData.max_rate / 100) * this.amount) * this.duration;

            let minimumProfitRange =  money(+this.amount + minimumProfit);
            let maximumProfitRange =  money(+this.amount + maximumProfit);

            this.profitRange = `${minimumProfitRange} - ${maximumProfitRange}`;
            this.result = `Your current license procures ${money(minimumProfit)} to ${money(maximumProfit)} after ${this.duration} days`;

        },
        format(value){
            return money(this.amount);
        },
        init(){
            this.$watch('license', (value) =>  {
                this.selectedLicenseData = event.currentTarget.options[event.currentTarget.selectedIndex].dataset;
            });
        }
    }));
</script>
@endscript