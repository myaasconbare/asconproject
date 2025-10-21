@use('App\Services\MatrixService')

@php($matrixService = resolve(MatrixService::class))

@php($martixSettings = $matrixService->getMatrixSettings()) 

<div x-data="matrix">
    <div class="main-content" data-simplebar="">
        <div class="row">
            <div class="col-lg-12">
                @if($matrixService->alreadyEnrolled())
                <div class="i-card-sm mb-4">
                    <h4 class="title">Matrix Enrolled Information</h4>
                    <div class="row g-3 row-cols-xl-4 row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1">
                        <div class="col">
                            <div class="i-card-sm p-3 primary--light shadow-none">
                                <p class="fs-15">Initiated At</p>
                                <h5 class="title-sm mb-0">
                                    {{ $matrixEnrollment->created_at }}
                                </h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="i-card-sm p-3 primary--light shadow-none">
                                <p class="fs-15">Trx</p>
                                <h5 class="title-sm mb-0">
                                    {{ $matrixEnrollment->transaction_id }}
                                </h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="i-card-sm p-3 primary--light shadow-none">
                                <p class="fs-15">Schema Name</p>
                                <h5 class="title-sm mb-0">
                                    {{ $matrixEnrollment->plan->name }}
                                </h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="i-card-sm p-3 primary--light shadow-none">
                                <p class="fs-15">Invest Amount</p>
                                <h5 class="title-sm mb-0">
                                    {{ money($matrixEnrollment->amount) }}
                                </h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="i-card-sm p-3 primary--light shadow-none">
                                <p class="fs-15">User-Based Referral Bonus</p>
                                <h5 class="title-sm mb-0">
                                   {{ money($matrixEnrollment->plan->referral_reward) }}
                                </h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="i-card-sm p-3 primary--light shadow-none">
                                <p class="fs-15">Referral Commission</p>
                                <h5 class="title-sm mb-0">
                                    {{ money($matrixEnrollment->referral_commission) }}
                                </h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="i-card-sm p-3 primary--light shadow-none">
                                <p class="fs-15">Level Commission</p>
                                <h5 class="title-sm mb-0">
                                    {{ money($matrixEnrollment->level_commission) }}
                                </h5>
                            </div>
                        </div>

                        <div class="col">
                            <div class="i-card-sm p-3 primary--light shadow-none">
                                <p class="fs-15">Status</p>
                                <h5 class="title-sm mb-0">
                                    {{ ucfirst($matrixEnrollment->status) }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="i-card-sm">
                    <div class="card-body">
                       <livewire:matrix-plans-list/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div wire:ignore class="modal fade" id="enrollMatrixModal" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                            <x-spinner wire:loading.class='d-flex' wire:target='submit'/> 
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
</div>
