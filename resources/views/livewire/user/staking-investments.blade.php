<div x-data="investment">
    <div class="main-content" data-simplebar="">
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">Staking Investment</h4>
                    </div>
                    <div class="filter-area">
                        <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                            <div class="col">
                                <button class="i-btn btn--lg btn--primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#staking-investment"><i class="bi bi-wallet me-3"></i> Invest
                                    Now</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row align-items-center gy-4 mb-3">
                            <div class="table-container">
                                <table id="myTable" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Initiated At</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Interest</th>
                                            <th scope="col">Total Return</th>
                                            <th scope="col">Expiration Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($investments as $investment)    
                                            <tr>
                                                <td data-label="Initiated At">
                                                    {{ $investment->initiated_at }}
                                                </td>
                                                <td data-label="Amount">
                                                    {{ money($investment->amount) }}
                                                </td>
                                                <td data-label="Interest">
                                                    {{ $investment->interest }}%
                                                </td>
                                                <td data-label="Total Return">
                                                    {{ money($investment->total_return) }}
                                                </td>
                                                <td data-label="Expiration Date">
                                                    {{ $investment->formatDate('expiration_date') }}
                                                </td>
                                                <td data-label="Status">
                                                    <span class="i-badge badge--info">
                                                        {{ ucfirst($investment->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{ $investments->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
                </div>
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

                <form wire:submit.prevent='submit'>
                   @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="amount" class="col-form-label">Duration</label>
                            <select x-model="selectedPlanId" class="form-control" name="plan_id" id="plan-select" x-ref="planSelect">
                                @foreach ($this->investmentPlans as $investmentPlan)    
                                <option value="{{ $investmentPlan->id }}" data-min="{{ $investmentPlan->minimum_amount }}" data-max="{{ $investmentPlan->maximum_amount }}" data-interest="{{ $investmentPlan->interest_rate }}">
                                    {{ $investmentPlan->duration_label }} - Interest {{ $investmentPlan->interest_rate }}%
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="col-form-label">Amount (<span x-ref="minAmountLabel" id="min-amount"></span> - <span
                                    id="max-amount" x-ref="maxAmountLabel"></span>)</label>
                            <div class="input-group mb-3">
                                <input x-model='amount' type="text" class="form-control" id="amount" name="amount"
                                    placeholder="Enter Amount" aria-label="Amount" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">USD</span>
                            </div>
                            <small id="total-return" class="text--light" x-ref="totalReturn">

                            </small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--light btn--md"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="i-btn btn--primary btn--md spin-btn">
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
    Alpine.data('investment', () => ({
        selectedPlanId : $wire.entangle('selectedPlanId'),
        amount : $wire.entangle('amount'),
        minAmount: null,
        maxAmount: null,
        interest: null,

        selectFirstPlan(){
            let select = event.currentTarget;
            let plan = this.$refs.planSelect.options[0];

            this.selectedPlanId = plan?.value;

            this.setLimits();
        },
        setLimits(){
            let select = this.$refs.planSelect;
            let plan = select.options[select.selectedIndex]?.dataset || {};

            this.$refs.minAmountLabel.textContent = '$' + (plan.min || "0.00");
            this.$refs.maxAmountLabel.textContent = '$' + (plan.max || "0.00");

            this.minAmount = +plan.min || '';
            this.maxAmount = +plan.max || '';
            this.interest = +plan.interest || '';

        },
        setTotalReturn(){
            let profit = (this.interest / 100) * +this.amount;
            let totalReturn = profit + +this.amount;

            if(isNaN(profit) || isNaN(totalReturn)) return;
            this.$refs.totalReturn.textContent = `Total Return: $${totalReturn} after the complete investment period`
        },
        init(){
            this.selectFirstPlan();

            this.$watch('selectedPlanId', this.setLimits.bind(this));

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
