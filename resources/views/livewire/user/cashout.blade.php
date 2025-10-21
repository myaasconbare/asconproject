<div x-data="cashout">
    <div class="main-content" data-simplebar="">
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4"> 
                    <button class="i-btn btn--primary btn--lg capsuled cash-out-process"
                    data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="1"
                    data-name="Bank Transfer" data-min_limit="1"
                    data-max_limit="100000">
                    Withdraw Now
                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                    </button>
                </div>
                <div class="i-card-sm">
                    <div class="filter-area">
                        <form>
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                <div class="col">
                                    <input type="text" name="search" placeholder="Trx ID" value="">
                                </div>
                                <div class="col">
                                    <select class="select2-js" name="status">
                                        <option value="2">PENDING</option>
                                        <option value="3">SUCCESS</option>
                                        <option value="4">CANCEL</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" id="date" class="form-control datepicker-here" name="date"
                                        value="" data-range="true" data-multiple-dates-separator=" - "
                                        data-language="en" data-position="bottom right" autocomplete="off"
                                        placeholder="Date">
                                </div>
                                <div class="col">
                                    <button type="submit" class="i-btn btn--lg btn--primary w-100"><i
                                            class="bi bi-search me-3"></i>Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center gy-4 mb-3">
                            <div class="table-container">
                                <table id="myTable" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Initiated At</th>
                                            <th scope="col">Trx</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Charge</th>
                                            <th scope="col">Final Amount</th>
                                           
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($withdrawals as $withdrawal)
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-20 03:05 PM
                                            </td>
                                            <td data-label="Trx">
                                                {{ $withdrawal->transaction_id }}
                                            </td>
                                            <td data-label="Amount">
                                                {{ $withdrawal->amount }}
                                            </td>
                                            <td data-label="Charge">
                                                {{ $withdrawal->charge }}
                                            </td>
                                            <td data-label="Final Amount">
                                                {{ $withdrawal->final_amount }}
                                            </td>
                                           
                                            <td data-label="Status">
                                                <span class="i-badge badge--primary">
                                                    {{ $withdrawal->status }}
                                                </span>
                                            </td>
                                        </tr>
                                           
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{ $withdrawals->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <div wire:ignore class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title" id="methodTitle">
                        Request Cashout
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit='submit' method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="text-end">
                            <p class="mb-0" id="withdraw_limit"></p>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="col-form-label">Amount</label>
                            <div class="input-group mb-3">
                                <input wire:model='form.amount' type="text" class="form-control" id="amount" name="amount"
                                    placeholder="Enter Amount" aria-label="Recipient's username"
                                    aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">USD</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="wallet" class="col-form-label">Wallet</label>
                            <select id="wallet" wire:model="form.selectedWallet" class="form-control"
                                aria-label="Default select example">
                                <option selected class="text-white bg-dark">
                                    Select Wallet
                                </option>
                                
                                <option value="deposit_wallet">
                                    Deposit Wallet - {{ money(auth()->user()->deposit_wallet) }}
                                </option>
                                <option value="interest_wallet">
                                    Interest Wallet - {{ money(auth()->user()->interest_wallet) }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="currency" class="col-form-label">Currency</label>
                            <select id="currency" wire:model="form.currencyId" class="form-control"
                                aria-label="Default select example">
                                <option selected class="text-white bg-dark">
                                    Select Currency
                                </option>
                                @foreach ($this->currencies as $currency)
                                <option value="{{ $currency->id }}">
                                    {{ $currency->name }} 
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="col-form-label">Wallet Address</label>
                            <div class="input-group mb-3">
                                <input wire:model='form.walletAddress' type="text" class="form-control" id="address" name="address"
                                    placeholder="Enter Wallet address">
                            </div>
                        </div>

                       

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--outline btn--sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="i-btn btn--primary btn--sm spin-btn-xs">
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
        Alpine.data('cashout', () => ({
            init(){
                $wire.on('server-message', (response) => {
                    $store.utils.handleServerMsg(response);
                    if(response[0].type == 'success'){
                        $('#exampleModal').modal('hide');
                    }
                });
            }
        }));
    </script>
@endscript


