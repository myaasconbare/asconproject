<div x-data="deposit">
    <div class="main-content" data-simplebar="">
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        {{-- <h4 class="title">New Deposit</h4> --}}
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                <button class="i-btn btn--primary btn--md capsuled deposit-process"
                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                data-name="Pay Stack" data-code="pay-stack" data-minimum="$100"
                                data-maximum="$100000">Deposit Now<i
                                    class="bi bi-box-arrow-up-right ms-2"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">Deposit Logs</h4>
                    </div>

                    <div class="filter-area">
                        <form>
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                <div class="col">
                                    <input type="text" name="search" placeholder="Trx ID" value="">
                                </div>
                                <div class="col">
                                    <select class="select2-js" name="status">
                                        <option value="pending">PENDING</option>
                                        <option value="success">SUCCESS</option>
                                        <option value="cancel">CANCEL</option>
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
                                            <th scope="col">Wallet</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($deposits as $deposit)      
                                        <tr>
                                            <td data-label="Initiated At">
                                                {{ $deposit->initiated_at }}
                                            </td>
                                            <td data-label="Trx">
                                                {{ $deposit->transaction_id }}
                                            </td>
                                            
                                            <td data-label="Amount">
                                                {{ money($deposit->amount) }}
                                            </td>
                                            <td data-label="Charge">
                                                {{ $deposit->charge }}
                                            </td>
                                            <td data-label="Final Amount">
                                                {{ money($deposit->amount) }}
                                            </td>
                                            <td data-label="Wallet">
                                                Deposit Wallet
                                            </td>
                                            <td data-label="Status">
                                                <span class="i-badge badge--info">
                                                    {{ $deposit->status }}
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

                {{ $deposits->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <div wire:ignore class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title" id="gatewayTitle">
                        Create New Deposit
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if($minimumDeposit > 0)
                    <h5 class="text-center pt-3">
                        <span class="text-warning">
                            Min Deposit - ${{ format_number($minimumDeposit) }}
                        </span>
                    </h4>
                @endif
                <form wire:submit.prevent='submit'>
                    @csrf
                    <div class="modal-body">
                        <h6 id="paymentLimitTitle" class="mb-1 mt-1 text-center"></h6>
                        <div class="mb-3">
                            <label for="amount" class="col-form-label">Amount</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" wire:model='form.amount' id="amount" name="amount"
                                    placeholder="Enter Amount" aria-label="Recipient's username"
                                    aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">USD</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="currency" class="col-form-label">Currency</label>
                            <select id="currency" wire:model="form.selectedCurrency" class="form-control"
                                aria-label="Default select example">
                                <option selected class="text-white bg-dark">
                                    Select Wallet
                                </option>
                                @foreach ($this->currencies as $currency)
                                <option value="{{ $currency }}">
                                    {{ $currency }} 
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--light btn--md"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="i-btn btn--primary btn--md">
                            <x-spinner wire:loading.class='d-flex' wire:target='submit'/> 
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title">Payment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="payment-details"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    Alpine.data('deposit', () => ({
        init(){
            $wire.on('server-message', $store.utils.handleServerMsg.bind($store.utils));
        }
    }));
</script>
@endscript