<div class="conversion-section bg-color pt-110 pb-110">
    <div class="linear-right"></div>
    <div class="container">
        <div class="row justify-content-center g-4">
            <div class="col-lg-7">
                <div class="section-title style-two text-center mb-60">
                    <h2>Top Crypto Conversions at Your Fingertips</h2>
                    <p>Explore the most popular cryptocurrency conversions on {{ config("app.name") }}. Our platform provides you with the latest, most sought-after exchange rates, ensuring you&#039;re always informed about high-performing currencies. Efficient, accurate, and designed for savvy traders like you.</p>
                </div>
            </div>
        </div>
        <div class="row g-3">
            @foreach ($currencies as $currency)     
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="converstion-item">
                        <div class="content">
                            <h5>{{ strtoupper($currency->symbol) }} <i class="bi bi-arrow-right"></i> USDT</h5>
                            <p>1 {{ strtoupper($currency->symbol) }} = {{ $currency->meta['current_price'] }} USDT</p>
                        </div>
                        <div class="icons">
                            <img src="{{ $currency->image }}?1696501400" alt="image">
                            <img src="{{ asset('files/usdt.png') }}" alt="image">
                        </div>
                    </div>
                </div>
            @endforeach
            
        </div>
    </div>
</div>