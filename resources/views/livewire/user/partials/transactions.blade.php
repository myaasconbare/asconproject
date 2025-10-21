<div class="row">
    <div class="col-lg-12">
        <div class="i-card-sm">
            <div class="card-header">
                <h4 class="title">
                    {{ $title }}
                </h4>
            </div>
            <div class="filter-area">
                <form>
                    <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                        <div class="col">
                            <input type="text" name="search" placeholder="Trx ID"  wire:model='search' />
                        </div>
                        <div class="col">
                            <select class="select2-js" name="wallet_type">
                                <option value="">All</option>
                                <option @selected($walletType == 'deposit_wallet') value="deposit_wallet">DEPOSIT</option>
                                <option @selected($walletType == 'interest_wallet') value="interest_wallet">INTEREST</option>
                                <option @selected($walletType == 'residual') value="residual">RESIDUAL</option>
                            </select>
                        </div>
                        <div class="col">
                            <select class="select2-js" name="source">
                                <option value="">ALL</option>
                                <option value="2">MATRIX</option>
                                <option value="3">INVESTMENT</option>
                                <option value="4">TRADE</option>
                            </select>
                        </div>
                        <div class="col">
                            <input
                                type="text"
                                id="date"
                                class="form-control datepicker-here"
                                name="date"
                                value=""
                                data-range="true"
                                data-multiple-dates-separator=" - "
                                data-language="en"
                                data-position="bottom right"
                                autocomplete="off"
                                placeholder="Date"
                            />
                        </div>
                        <div class="col">
                            <button type="submit" class="i-btn btn--lg btn--primary w-100"><i class="bi bi-search me-3"></i>Search</button>
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
                                    <th scope="col">Post Balance</th>
                                    <th scope="col">Charge</th>
                                    <th scope="col">Source</th>
                                    <th scope="col">Wallet</th>
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
                                    <td data-label="Amount">
                                        <span @class(['text-danger' => !$transaction->type, 'text-success' => $transaction->type ])>
                                            {{ money($transaction->amount) }}
                                        </span>
                                    </td>
                                    <td data-label="Post Balance">
                                        {{ $transaction->post_balance_label }}
                                    </td>
                                    <td data-label="Charge">$0</td>
                                    <td data-label="Wallet">
                                        <span class="i-badge badge--primary text-capitalize">
                                            {{ strtolower($transaction->source) }}
                                        </span>
                                    </td>
                                    <td data-label="Source">
                                        <span class="i-badge badge--success text-capitalize">
                                            {{ strtolower($transaction->wallet_type_label) }}
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
            @if(!$limit)
                {{ $transactions->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
            @endif
        </div>
    </div>
</div>