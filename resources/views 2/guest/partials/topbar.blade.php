<section class="topbar">
    <div class="container-fluid px-0">
        <div class="marquee marquee-one" data-gap='10' data-duplicated='true'>
            <div class="marquee-items">
            @foreach ($cryptoCurrencies as $cryptoCurrency)     
                <div class="marquee-item">
                    <div class="marquee-item-img">
                        <img src="{{ $cryptoCurrency->image }}?1696501400" alt="Bitcoin">
                    </div>
                    <h6>{{ $cryptoCurrency->pair }}</h6>
                    <span>{{ $cryptoCurrency->meta['current_price']}} ({{ $cryptoCurrency->meta['price_change_24h'] }}%)</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>