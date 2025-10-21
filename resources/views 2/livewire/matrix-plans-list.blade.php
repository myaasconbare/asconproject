<div x-data="matrixPlan" class="row align-items-center gy-4">
    @foreach ($matrixPlans as $matrixPlan)
    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6">
        <div class="pricing-item card-style">
            @if($matrixPlan->is_recommended)
            <div class="recommend">
                <span>Recommend</span>
            </div>
            @endif
            <div class="icon">
                <img src="{{ asset('files/award.png') }}" alt="Award Image" border="0">
            </div>
            <div class="header">
                <div class="price">{{ money($matrixPlan->amount) }}</div>
                <h4 class="title">{{ $matrixPlan->name }}</h4>
                <div class="price-info">
                    @php($aggregateCommission = $matrixService->calculateAggregateCommission($matrixPlan->id))
                    <h6 class="mb-1">Straightforward Referral Reward: {{ money($matrixPlan->referral_reward) }}</h6>
                    <h6 class="mb-2">Aggregate Level Commission: ${{$aggregateCommission }}</h6>
                    <p class="mb-0">
                        Get back
                        <span>
                            {{ ($aggregateCommission / $matrixPlan->amount) * 100 }}%
                        </span>
                        of what you invested
                    </p>
                </div>
            </div>
            <div class="body">
                <ul class="pricing-list">
                    @foreach ($matrixService->getLevelsById($matrixPlan->id) as $level)
                    @php($matrix = pow($martixSettings->width, $loop->iteration))
                    <li>
                        Level-{{ $level['level'] }} &nbsp; >> &nbsp;
                        {{ money($level['commission']) }} x {{ $matrix }}
                        = {{ money($matrix * $level['commission']) }}
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="footer">
                <button x-on:click="showEnrollMatrixModal({{ $matrixPlan->id }})"
                    class="i-btn btn--primary btn--lg capsuled w-100 enroll-matrix-process" {{-- data-bs-toggle="modal"
                    data-bs-target="#enrollMatrixModal" --}} data-uid="XVaMNGiOUnj3690h" data-name="Intermediate">
                    Start Investing
                    Now
                </button>
            </div>
        </div>
    </div>
    @endforeach

    @teleport('body')
    <div>
        <div wire:ignore class="modal fade" id="enrollMatrixModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="matrixTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit='submit' method="POST" action="">
                        @csrf
                        <div class="modal-body">
                            <p>Are you sure you want to enroll in this matrix scheme?</p>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="i-btn btn--primary btn--sm spin-btn">
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
    Alpine.data('matrixPlan', () => ({
            selectedPlanId: $wire.entangle('selectedPlanId'),
            showEnrollMatrixModal(planId){
                this.selectedPlanId = planId;
                $('#enrollMatrixModal').modal('show')
            },
            init(){
                $('#enrollMatrixModal').on('hide.bs.modal', function() {
                   this.selectedPlanId = null;
                });

                $wire.on('server-message', (response) => {
                    $store.utils.handleServerMsg(response);
                    $('#enrollMatrixModal').modal('hide')
                });
            }
        }));
</script>
@endscript