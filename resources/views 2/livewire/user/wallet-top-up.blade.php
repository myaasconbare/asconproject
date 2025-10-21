<div x-data="topUp" class="main-content" data-simplebar="">
    <div class="i-card-sm p-3 mb-4">
        <div class="row g-3">
            <div class="col-lg-4 col-md-6">
                <div class="i-card-sm style-2 bg--dark shadow-none rounded-2">
                    <span class="text--light">Deposit Wallet</span>
                    <span class="text-white fw-bold">
                        {{ money(auth()->user()->deposit_wallet) }}
                    </span>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="i-card-sm style-2 bg--dark shadow-none rounded-2">
                    <span class="text--light">Interest Wallet</span>
                    <span class="text-white fw-bold">
                        {{ money(auth()->user()->interest_wallet) }}
                    </span>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="i-card-sm style-2 bg--dark shadow-none rounded-2">
                    <span class="text--light">Residual Wallet</span>
                    <span class="text-white fw-bold">
                        {{ money(auth()->user()->residual_wallet) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="i-card-sm mb-4 d-flex justify-content-center">
            <div class="col-8">
                <div class="card-header">
                    <h4 class="fs-17 border--left mb-4">
                        Transfer from Deposit Wallet other wallet
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row align-items-center gy-4">
                        <div class="user-form">
                            <form wire:submit='submit'>
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="account">Account</label>
                                            <select wire:model='wallet' id="account" name="account" required="">
                                                <option value="">Select One</option>
                                                <option value="trade_wallet">Trade Wallet</option>
                                                {{-- <option value="3">TRADE</option> --}}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="amount">Amount</label>
                                            <input wire:model='amount' type="number" id="amount" name="amount" placeholder="Enter Amount"
                                                required="" />
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="i-btn btn--primary btn--lg spin-btn">
                                            <x-spinner wire:loading.class='d-flex' wire:target='submit' />
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

@script
<script>
    Alpine.data('topUp', () => ({
            init(){
                $wire.on('server-message', $store.utils.handleServerMsg.bind($store.utils));
            }
        }));
</script>
@endscript