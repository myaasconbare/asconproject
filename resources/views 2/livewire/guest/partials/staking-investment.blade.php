<div x-data="stakingInvestment">
    <div class="investment-section pt-110 pb-110">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-lg-7">
                    <div class="section-title text-center mb-60">
                        <h2>Staking Investment</h2>
                        <p>Optimize Your Earnings with Cutting-Edge Staking Options</p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($this->investmentPlans as $investmentPlan)
                <div class="col-xl-6">
                    <div class="invest-card">
                        <div class="interest">
                            <h4>
                                {{ $investmentPlan->interest_rate }}%
                            </h4>
                            <span>Interest</span>
                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-sm-4">
                                <div class="info-item">
                                    <span>Duration</span>
                                    <span>{{ $investmentPlan->duration_label }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="info-item">
                                    <span>Capital Limit</span>
                                    <span>{{ money($investmentPlan->minimum_amount) }} - {{
                                        money($investmentPlan->maximum_amount) }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-end">
                                    <button value="{{ $investmentPlan->id }}" data-id="{{ $investmentPlan->id }}"
                                        data-min="{{ $investmentPlan->minimum_amount }}"
                                        data-max="{{ $investmentPlan->maximum_amount }}"
                                        data-interest="{{ $investmentPlan->interest_rate }}"
                                        x-on:click="selectPlan"
                                        class="i-btn btn--primary btn--md capsuled invest-process staking-investment-proces"
                                        {{-- data-bs-toggle="modal" data-bs-target="#staking-investment"  --}}
                                        data-min="$100"
                                        data-max="$200" data-interest="2.00" data-plan_id="1">Invest Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div wire:ignore class="modal fade" id="staking-investment" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title">Staking Invest Now</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit.prevent='submit' method="POST">
                   @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="staking-amount" class="col-form-label">Amount (<span x-ref="minAmountLabel" id="min-amount"></span> -
                                <span x-ref="maxAmountLabel" id="max-amount"></span>)</label>
                            <div class="input-group mb-3">
                                <input x-model="amount" type="text" class="form-control" id="staking-amount"
                                    name="amount" placeholder="Enter Amount" aria-label="Amount"
                                    aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">USD</span>
                            </div>
                            <small x-ref="totalReturn" id="staking-total-return"></small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--light btn--md" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="i-btn btn--primary btn--md">
                            <x-spinner wire:loading.class='d-flex' wire:target='submit'/> 
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
    Alpine.data('stakingInvestment', () => ({
        selectedPlanId : $wire.entangle('selectedPlanId'),
        amount : $wire.entangle('amount'),
        minAmount: null,
        maxAmount: null,
        interest: null,

        selectPlan(){
            let plan = event.currentTarget.dataset;

            this.selectedPlanId = plan.id;

            this.$refs.minAmountLabel.textContent = '$' + plan.min;
            this.$refs.maxAmountLabel.textContent = '$' + plan.max;

            this.minAmount = +plan.min;
            this.maxAmount = +plan.max;
            this.interest = +plan.interest;

            $('#staking-investment').modal('show');

        },
        setTotalReturn(){
            let parsedAmount = parseFloat(this.amount.replace(/[^0-9.-]+/g, ""));
            
            if (isNaN(parsedAmount)) return;

            let profit = (this.interest / 100) * +this.amount;
            let totalReturn = profit + +this.amount;
            this.$refs.totalReturn.textContent = `Total Return: $${totalReturn} after the complete investment period`
        },
        init(){
            
            this.$watch('amount', this.setTotalReturn.bind(this));

            $wire.on('server-message', (response) => {
                $store.utils.handleServerMsg(response);

                if(response[0].type == 'success'){
                    $('#staking-investment').modal('hide')
                }
            });
        }
    }));
</script>
@endscript