@props(['currencies'])


<div class="row">
    <div class="col-lg-12">
        <div class="table-container">
            <table id="myTable" class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Pair Price</th>
                        <th scope="col">Daily Change</th>
                        <th scope="col">Daily High</th>
                        <th scope="col">Daily Low</th>
                        <th scope="col">Total Volume</th>
                        <th scope="col">Market Cap</th>
                        <th scope="col">Total Supply</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    @foreach ($currencies as $currency)

                    <tr>
                        <td data-label="Name">
                            <a href="users/trades/binary/bitcoin.html" class="our-currency-item">
                                <div class="name d-flex gap-2">
                                    <div class="avatar--md">
                                        <img src="{{ $currency->image }}?1696501400"
                                            alt="Bitcoin">
                                    </div>
                                    <div class="content">
                                        <h5>{{ $currency->name }}</h5>
                                        <span>{{ strtoupper($currency->symbol) }} Coin</span>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td data-label="Pair Price">
                            <div class="amount">
                                {{ $currency->pair }}
                            </div>
                        </td>
                        <td data-label="Daily Change">
                            <div class="rate">
                                <p>
                                    {{ $currency->meta['price_change_24h'] }}
                                </p>
                            </div>
                        </td>
                        <td data-label="Daily High">
                            <div class="high">
                                <p>{{ $currency->meta['high_24h'] }}%</p>
                            </div>
                        </td>
                        <td data-label="Daily Low">
                            <div class="low">
                                <p>{{ $currency->meta['low_24h'] }} %</p>
                            </div>
                        </td>
                        <td data-label="Total Volume">
                            <div class="total_volume">
                                <p>{{ $currency->meta['total_volume'] }}%</p>
                            </div>
                        </td>
                        <td data-label="Market Cap">
                            <div class="total_volume">
                                <p>{{ $currency->meta['market_cap'] }}</p>
                            </div>
                        </td>
                        <td data-label="Total Supply">
                            <div class="total_volume">
                                <p>{{ $currency->meta['total_supply'] }}</p>
                            </div>
                        </td>

                        <td data-label="Action">
                            <div class="action">
                                <a href="{{ route('user.trade-binary', ['cryptoId' => $currency->crypto_id]) }}"
                                    class="i-btn btn--sm btn--primary-outline capsuled">Trade</a>
                                <a href="{{ route('user.trade-practice', ['cryptoId' => $currency->crypto_id]) }}"
                                    class="i-btn btn--sm btn--lite--secondary capsuled">Practice</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>