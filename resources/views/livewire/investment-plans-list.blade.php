<div x-data="investmentPlans" class="row align-items-center gy-4">
    @foreach ($portfolios as $portfolio)
    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6">
        <div class="pricing-item style-two">
            @if($portfolio->is_recommended)
            <div class="recommend">
                <span>Recommend</span>
            </div>
            @endif

            <div class="header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="title">
                        {{ $portfolio->name }}
                    </h4>
                    <div class="price mt-0">
                        {{ $portfolio->duration }} {{ $portfolio->period_label }}
                    </div>
                </div>

                <div class="d-flex justify-content-between flex-wrap align-items-center gap-2">
                    <p class="text-start fs-16 mb-0">
                        {{-- Interest Rate: --}}
                        <span class="text-white">
                            {{-- {{ $portfolio->rate }}% --}}
                        </span>
                    </p>
                    <button x-on:click="setTerms" class="fs-15 terms-policy bg-transparent" type="button"
                        data-bs-toggle="modal" data-bs-target="#termsModal" data-terms_policy="{{ $portfolio->terms }}">
                        <i class="bi bi-info-circle me-2 color--primary"></i>Terms and
                        Policies
                    </button>
                </div>
            </div>
            <div class="body">
                <h6 class="mb-4">
                    <span class="text--light">
                        License Cost
                    </span> : {{ money($portfolio->least_plan->minimum_amount) }} - {{
                    $portfolio->max_plan->maximum_amount_format }}

                </h6>
                <h6 class="mb-4">
                    <span class="text--light">
                        Profit Range
                    </span> : {{ $portfolio->least_plan->minimum_interest_rate }}% - {{
                    $portfolio->max_plan->maximum_interest_rate }}%
                </h6>
                {{-- <h6 class="mb-4">
                    <span class="text--light">
                        Investment amount limit
                    </span> : {{ money($portfolio->minimum_amount) }}
                    - {{ $portfolio->maximum_amount_format }}
                </h6> --}}

                <ul class="pricing-list">
                    {{-- @foreach ($portfolio->features[0] as $feature)
                    <li>
                        <span>
                            {{ $feature }}
                        </span>
                    </li>
                    @endforeach --}}
                </ul>

                <h6 class="mb-4">
                    <span class="text-end text--light">Total Return</span> :
                    100% + capital

                </h6>
            </div>
            <div class="footer">
                <button x-on:click="selectLicense" class="i-btn btn--dark btn--lg capsuled w-100 invest-process"
                    data-bs-toggle="modal" data-bs-target="#investModal" data-portfolio="{{ $portfolio->name }}"
                    data-id="{{ $portfolio->id }}">Invest Now</button>
            </div>
        </div>
    </div>
    @endforeach

    @teleport('body')
    <div>
        <div wire:ignore x-ref="termsModal" class="modal fade" id="termsModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Terms and policy</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div x-ref="investTerms" id="invest_terms"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--danger btn--md" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore class="modal fade" id="investModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 x-ref="investTitle" class="modal-title" id="investTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form wire:submit.prevent='submit'>
                        @csrf
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="amount" class="col-form-label">Amount</label>
                                <div class="input-group mb-3">
                                    <input wire:model="form.amount" type="text" class="form-control" id="amount"
                                        name="amount" placeholder="Enter Invest amount"
                                        aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">USD</span>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="i-btn btn--outline btn--md"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="i-btn btn--primary btn--md spin-btn">
                                <x-spinner wire:loading.class='d-flex' wire:target='submit' />
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endteleport
</div>

@script
<script>
    Alpine.data('investmentPlans', () => ({
        selectedPortfolio: $wire.entangle('form.selectedPortfolio'),
        setTerms(){
            this.$refs.investTerms.textContent = event.currentTarget.dataset.terms_policy
        },
        selectLicense(){
            let investProcess = event.currentTarget;
            this.selectedPortfolio = investProcess.dataset.id;
            this.$refs.investTitle.textContent = "Invest on a " + investProcess.dataset.portfolio + " License";
        },
        init(){
            $wire.on('server-message', (response) => {
                $store.utils.handleServerMsg(response);
                if(response[0].type == 'success'){
                    $('#investModal').modal('hide');
                }
            });
        }
    }));
</script>
@endscript