<div x-data="activeInvestment">
    <div class="main-content" data-simplebar="">
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">Investment Records</h4>
                    </div>
                    <div class="filter-area">
                        <form>
                            @csrf
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                <div class="col">
                                    <input type="text" name="search" placeholder="Trx ID" value="">
                                </div>
                                <div class="col">
                                    <select class="select2-js" name="status">
                                        <option value="1">INITIATED</option>
                                        <option value="2">PROFIT COMPLETED</option>
                                        <option value="3">COMPLETED</option>
                                        <option value="4">CANCELLED</option>
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
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-container">
                                    <table id="myTable" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Initiated At</th>
                                                <th scope="col">Trx</th>
                                                <th scope="col">Batch</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Active Interest Rate</th>
                                                <th scope="col">Interest Received</th>

                                                <th scope="col">Upcoming Payment</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($investments as $investment)
                                            <tr>
                                                <td data-label="Initiated At">
                                                    {{ formatDate($investment->created_at) }}
                                                </td>
                                                <td data-label="Trx">
                                                    {{ $investment->transaction_id }}
                                                </td>
                                                <td data-label="Plan">
                                                    {{ $investment->license->portfolio->name }}
                                                </td>
                                                <td data-label="Amount">
                                                    {{ money($investment->amount) }}
                                                </td>
                                                <td data-label="Should Pay">
                                                    {{ ($investment->active_interest_rate) }}%
                                                </td>
                                                <td data-label="Interest">
                                                    {{ money($investment->interests_received) }}
                                                </td>

                                                <td data-label="Upcoming Payment">
                                                    <span>N/A</span>
                                                </td>
                                                <td data-label="Status">
                                                    <span class="i-badge badge--success capsuled">
                                                        {{ strtoupper($investment->status_label) }}
                                                    </span>
                                                </td>
                                                <td data-label="Action">
                                                    {{-- <span>N/A</span> --}}

                                                    {{-- {{ self::REQUEST_END_LICENSE }} --}}

                                                    @if($investment->status == 'pending_termination')
                                                    <button wire:click='submit({{ $investment->id }}, "{{ self::CANCEL_TERMINATION }}")'
                                                        class="btn i-btn btn--primary text-uppercase btn-spin spin-btn-xs">
                                                        <x-spinner wire:loading.class='d-flex' wire:target='submit' />
                                                        cancel
                                                    </button>
                                                    @else

                                                    <button wire:click='submit({{ $investment->id }}, "{{ self::REQUEST_END_LICENSE }}")'
                                                        class="btn i-btn btn--primary text-uppercase btn-spin spin-btn-xs">
                                                        <x-spinner wire:loading.class='d-flex' wire:target='submit' />
                                                        end batch license
                                                    </button>
                                                    @endif


                                                </td>
                                            </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ $investments->appends($_GET)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="reInvestModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title">Confirmed Re-Investment Process</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="/users/investments/make/re-investment">
                    <input type="hidden" name="_token" value="ZyDveNXawIL2DDPM1j7DRuPYQzXeExy4KYf0dkVv"
                        autocomplete="off"> <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p>You&#039;re reinvesting in your current plan. Add more funds by including a new amount
                        </p>
                        <div class="mb-3">
                            <label for="amount" class="col-form-label">Amount</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="amount" name="amount"
                                    placeholder="Enter investment amount" aria-label="Recipient's username"
                                    aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">USD</span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="i-btn btn--primary btn--md">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title">Confirmed Cancellation of Investment Process</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="/users/investments/cancel">
                    <input type="hidden" name="_token" value="ZyDveNXawIL2DDPM1j7DRuPYQzXeExy4KYf0dkVv"
                        autocomplete="off"> <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p>Are you sure you want to cancel this investment?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="i-btn btn--primary btn--md">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title">Confirm Investment Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="/users/investments/complete-profitable">
                    <input type="hidden" name="_token" value="ZyDveNXawIL2DDPM1j7DRuPYQzXeExy4KYf0dkVv"
                        autocomplete="off"> <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p>
                            <span class="deducted_amount"></span> Transferred to Your Investment Wallet
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="i-btn btn--primary btn--md">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@script
<script>
    Alpine.data('activeInvestment', () => ({
            init(){
                $wire.on('server-message', $store.utils.handleServerMsg.bind($store.utils));
            }
        }));
</script>
@endscript