<div x-data="investment"> 
    <div class="main-content" data-simplebar="">
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title">
                            Enhancing Capital through Binary Investments
                        </h4>
                    </div>
                    <div class="card-body">
                        <livewire:investment-plans-list/>  
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- <div wire:ignore x-ref="termsModal" class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<div wire:ignore class="modal fade" id="investModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input wire:model="form.amount" type="text" class="form-control" id="amount" name="amount"
                                placeholder="Enter Invest amount" aria-label="Recipient's username"
                                aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">USD</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="i-btn btn--outline btn--md"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="i-btn btn--primary btn--md spin-btn">
                        <x-spinner wire:loading.class='d-flex' wire:target='submit'/> 
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
</div>
