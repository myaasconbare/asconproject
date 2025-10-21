<div class="main-content" data-simplebar="">
    <div class="row">
        <div class="col-lg-12">
            <div class="i-card-sm">
                <div class="card-header">
                    <h4 class="title">
                        {{ $title }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="filter-area">
                                <form>
                                    <div class="row row-cols-lg-3 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                        <div class="col">
                                            <input type="text" name="search" placeholder="Trx ID" wire:model='search' />
                                        </div>
                                        <div class="col">
                                            <input type="text" id="date" class="form-control datepicker-here"
                                                name="date" value="" data-range="true"
                                                data-multiple-dates-separator=" - " data-language="en"
                                                data-position="bottom right" autocomplete="off" placeholder="Date">
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="i-btn btn--lg btn--primary w-100"><i
                                                    class="bi bi-search me-3"></i>Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="table-container">
                                <table id="myTable" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Initiated At</th>
                                            <th scope="col">Trx</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ( $transactions as $transaction )
                                        <tr>
                                            <td data-label="Initiated At">
                                                {{ $transaction->initiated_at }}
                                            </td>
                                            <td data-label="Trx">
                                                {{ $transaction->transaction_id }}
                                            </td>
                                            <td data-label="User">
                                                {{ maskEmail($transaction->transactionable->fromUser->email) }}
                                            </td>
                                            <td data-label="Amount">
                                                <span @class(['text-danger'=> !$transaction->type, 'text-success' =>
                                                    $transaction->type ])>
                                                    {{ money($transaction->amount) }}
                                                </span>
                                            </td>
                                            <td data-label="Details">
                                                {{ $transaction->details }}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-white text-center" colspan="100%">No Data Found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{ $transactions->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
            </div>
            <div class="mt-4"></div>
        </div>
    </div>
</div>