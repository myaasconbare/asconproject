<div class="main-content" data-simplebar="">
    <div class="row">
        <div class="col-lg-12">
            <div class="i-card-sm mb-4">
                <div class="card-header">
                    <h4 class="title">Trades</h4>
                </div>

                <div class="table-container">
                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Pair</th>
                                <th scope="col">Price</th>
                                <th scope="col">Market Cap</th>
                                <th scope="col">Daily High</th>
                                <th scope="col">Daily Low</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                      <tbody>
                        @foreach ($currencies as $currency)                            
                        <tr>
                            <td data-label="Pair">
                                <div
                                    class="name d-flex align-items-center justify-content-md-start justify-content-end gap-lg-3 gap-2">
                                    <div class="icon">
                                        <img src="{{ $currency->image }}"
                                            class="avatar--sm" alt="Crypto-Image">
                                    </div>
                                    <div class="content">
                                        <h6 class="fs-14">
                                            {{ $currency->pair }}
                                        </h6>
                                        <span class="fs-13 text--light">
                                            {{ $currency->name }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Price">
                                ${{ $currency->meta['current_price'] }}
                            </td>
                            <td data-label="Market Cap">
                                {{ $currency->meta['market_cap'] }}
                            </td>
                            <td data-label="Daily High">
                                {{ $currency->meta['high_24h'] }} %
                            </td>
                            <td data-label="Daily Low">
                                {{ $currency->meta['low_24h'] }} %
                            </td>
                            <td data-label="Action">
                                <a href="{{ route('user.trade-binary', ['cryptoId' => $currency->crypto_id]) }}"
                                    class="i-btn btn--sm btn--primary capsuled">
                                    Trade
                                </a>
                                <a href="{{ route('user.trade-practice', ['cryptoId' => $currency->crypto_id]) }}"
                                    class="i-btn btn--sm btn--primary-outline capsuled">
                                    Practice
                                </a>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
                {{ $currencies->appends($_GET)->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>