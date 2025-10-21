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
                                                @php($range = $this->getRange($portfolio))
                                                <option 
                                                    data-min_amount="{{ $range['minimum_amount'] }}"
                                                    data-max_amount="{{ $range['maximum_amount'] }}"
                                                    data-is_unlimited="{{ $range['is_unlimited'] }}"
                                                    value="{{ $portfolio->id }}"
                                                >
                                                    {{ $portfolio->name }} : {{ $range['label'] }}
                                                </option>
                                                
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
        computedLicense : null,
        computedPortolio: null,
        licenses : @js($licenses),
        portfolios : @js($portfolios),
        showResult(){
            this.computedLicense = this.$store.utils.determineLicense(+this.amount, this.licenses);

            try {
                
                this.$store.calculator.showResult.call(this);
                    
            } catch (error) {

                return notifyError(error.message);
            }
        },
        format(value){
            return money(this.amount);
        },
        reactTo(property){
            this.$watch(property, (value) =>  {
                this.computedLicense = this.$store.utils.determineLicense(+this.amount, this.licenses);
                this.computedPortolio = this.$refs.license.options[this.$refs.license.selectedIndex].dataset;

            });
        },
        init(){
            ['license', 'amount'].forEach((property) => this.reactTo(property));
        }
    }));
</script>
@endscript