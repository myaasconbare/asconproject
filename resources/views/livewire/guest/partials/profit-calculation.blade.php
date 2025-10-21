@assets
<style>
    .days-input {
        background: rgba(0, 0, 0, 0);
        border: 1px solid rgba(255, 255, 255, 0.45) !important;
        border-radius: 10px;

    }

    .days-input:focus-within {
        /* border: 1px solid 1px solid rgba(255,255,255,0.45); */
    }

    .days-input .input-group-text {
        border: 0px !important;
        border-left: 1px solid rgba(255, 255, 255, 0.45) !important;
    }

    @media (max-width: 991px) {
        .days-input input {
            padding: 8px 15px;
        }
    }

    .days-input input {
        border: 0px !important;
        border-right: 1px solid var(--color-border);
        background: rgba(0, 0, 0, 0) !important;
        outline: none !important;
        box-shadow: none !important;
        font-size: 16px;
        padding: 10px 14px;
        color: #fff !important;
    }

    .days-input input::placeholder {
        color: var(--color-border);
    }

    .days-input:focus-within input {
        border: 0px;
        border-right: 1px solid 1px solid rgba(255, 255, 255, 0.45);
    }

    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        /* &, &:hover, &:focus, &:active {
            transition-delay: 3600s !important;
            color: red;
        } */
        transition: background-color 3600s ease-in-out 0s !important;

        /* color: #ffffff; */
        /* -webkit-background-clip: text !important; */
        -webkit-text-fill-color: #fff !important;

    }
</style>
@endassets

<div x-data="calculator" class="profit-calc-section bg-color pt-110 pb-110">
    <div class="linear-big"></div>
    <div class="container">
        <div class="row justify-content-start mb-60">
            <div class="col-xl-6 col-lg-8">
                <div class="section-title style-two text-start mb-60">
                    <h2>Profit Calculation</h2>
                    <p>Accurate and Transparent Profit Projections for Informed Investment Decisions</p>
                </div>
            </div>
        </div>
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <div class="profit-calc-wrapper">
                    <form class="profit-form" x-on:submit.prevent="showResult" method="POST">
                        <div class="col-lg-12">
                            <div class="form-inner">
                                <label for="duration" class="text-uppercase">
                                    How long do you want to invest?
                                </label>
                                <div class="input-group days-input form-control p-0">
                                    <input x-model="duration" placeholder="Enter duration" type="text" id="duration"
                                        class="form-control  b-0 duration" />
                                    <span class="input-group-text text-white bg-transparent textwhite"
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
                                <input x-model="amount" type="number" id="amount" name="amount"
                                    placeholder="Enter Amount" required="" />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-inner">
                                <label for="account" class="text-uppercase">select preferred license <span
                                        x-text="amountRange"></span></label>
                                <select x-ref="license" x-model='license' id="account" name="account" required="">
                                    <option value="">Select One</option>
                                    @foreach ($portfolios as $portfolio)
                                        @php($range = $this->getRange($portfolio))
                                        <option 
                                            data-min_amount="{{ $range['minimum_amount'] }}"
                                            data-max_amount="{{ $range['maximum_amount'] }}"
                                            data-is_unlimited="{{ $range['is_unlimited'] }}"
                                            data-name="{{ $portfolio->name }}"
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
                    <div class="profit-content">
                        <h5 id="invest-total-return"></h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <h4 class="text-white profit-subtitle mb-lg-5 mb-4">Profit Calculation</h4>
                <ul class="profit-list">
                    <li>
                        <span>License</span>
                        <span x-ref="plan_name" id="plan_name" x-text="computedPortolio?.name || 'N/A'">N/A</span>
                    </li>
                    <li>
                        <span>Amount</span>
                        <span x-ref="cal_amount" x-text="amount ? format(amount) : 'N/A'" id="cal_amount">N/A</span>
                    </li>
                    <li>
                        <span>Duration</span>
                        <span x-ref="duration" id="duration" x-text="duration ? duration + ' days' : 'N/A'">N/A</span>
                    </li>
                    <li>
                        <span>Profit</span>
                        <span x-ref="profit" x-text="profitRange || 'N/A'" id="profit">N/A</span>
                    </li>
                    {{-- <li>
                        <span>Capital Back</span>
                        <span x-ref="capital_back" id="capital_back">N/A</span>
                    </li>
                    <li>
                        <span>Total</span>
                        <span x-ref="total_invest" id="total_invest">N/A</span>
                    </li> --}}
                </ul>
                <p class="text-center text-warning py-4" x-text="result"></p>
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
        profitRange: null,
        amountRange: null,
        computedLicense : null,
        computedPortolio : null,
        licenses : @js($licenses),
        portfolios : @js($portfolios),
        reset(){
            this.profitRange = null;
            this.result = null;
        },
        showResult(){
            this.computedLicense = this.$store.utils.determineLicense(+this.amount, this.licenses);

            try {
                this.$store.calculator.showResult.call(this);
                    
            } catch (error) {
                console.log('hello', error);
                return notifyError(error.message);
            }
        },
        format(value){
            return money(this.amount);
        },
        init(){
            this.$watch('duration', () => this.reset());

            this.$watch('license', (value) =>  {
                this.computedPortolio = this.$refs.license.options[this.$refs.license.selectedIndex].dataset;
            });
        }
    }));
</script>
@endscript