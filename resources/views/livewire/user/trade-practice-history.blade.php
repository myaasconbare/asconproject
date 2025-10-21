<div>
    <div class="main-content" data-simplebar="">
        <div x-data="trades" class="row">
            <div class="col-lg-12">
                
    
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title">Trade Practice logs</h4>
                    </div>
                    <div class="filter-area">
                        <form>
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                <div class="col">
                                    <select class="select2-js" name="outcome">
                                        <option selected value>ALL</option>
                                        <option @selected($outcome == 'initiated') value="initiated">INITIATED</option>
                                        <option @selected($outcome == 'win') value="win">WIN</option>
                                        <option @selected($outcome == 'lose') value="lose">LOSE</option>
                                        <option @selected($outcome == 'draw') value="draw">DRAW</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select wire:model='volume' class="select2-js" name="volume">
                                        <option selected value>ALL</option>
                                        <option @selected($volume == '1') value="1">HIGH</option>
                                        <option @selected($volume == '0') value="0">LOW</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" wire:model='date' id="date" class="form-control datepicker-here" name="date"
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
    
                    <div class="table-container">
                        <table id="myTable" class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Initiated At</th>
                                    <th scope="col">Crypto</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Arrival Time</th>
                                    <th scope="col">Volume</th>
                                    <th scope="col">Outcome</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trades as $trade)
                                <tr>
                                    <td data-label="Initiated At">
                                        {{ formatDate($trade->created_at) }}
                                    </td>
                                    <td data-label="Crypto">
                                        {{ $trade->cryptoCurrency->name }}
                                    </td>
                                    <td data-label="Price">
                                        {{ money($trade->original_price) }}
                                    </td>
                                    <td data-label="Amount">
                                        @if ($trade->is_win)   
                                            {{ money($trade->amount) }} + {{ money($trade->winning_amount) }} = 
                                            <span class="text--success">
                                                {{ money($trade->profit) }}
                                            </span>
                                        @elseif($trade->is_draw)
                                            <span class="text--primary">
                                                {{ money($trade->amount) }}
                                            </span>
                                        @else
                                            <span class="text--danger">
                                                {{ money($trade->amount) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td data-label="Arrival Time">
                                        {{ formatDate($trade->arrival_time) }}
                                    </td>
                                    <td data-label="Volume">
                                        <span class="i-badge badge--danger text-apitalize">
                                            {{ strtolower($trade->volume_label) }}
                                        </span>
                                    </td>
                                    <td data-label="Outcome">
                                        <span class="i-badge text-apitalize badge--{{ $trade->outcome_color }}">
                                            {{ $trade->outcome }}
                                        </span>
                                    </td>
                                    <td data-label="Status">
                                        <span class="i-badge badge--{{ $trade->status_color }}">
                                            {{ $trade->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
    
                    {{ $trades->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
               
                </div>
            </div>
        </div>
    </div>
   
</div>

@script
<script>
    Alpine.data('trades', () => ({
        init(){
                $wire.on('server-message', (response) => {
                    $store.utils.handleServerMsg(response);
                    if(response[0].type == 'success'){
                        $('#topUpModal').modal('hide');
                    }
                });
            }
    }));
</script>
@endscript