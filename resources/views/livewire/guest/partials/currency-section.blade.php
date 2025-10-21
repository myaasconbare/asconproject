<div class="currency-section full--width pt-110 pb-110">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7 col-md-9">
                <div class="section-title text-center mb-60">
                    <h2>Advanced Currency Exchange</h2>
                    <p>Navigate the cryptocurrency market with precision. Our platform offers real-time pricing,
                        comprehensive market analysis, and trend forecasts to inform and enhance your trading strategy.
                        Stay ahead in the dynamic world of crypto with {{ config("app.name") }}&#039;s insightful
                        exchange tools.</p>
                </div>
            </div>
        </div>
        <div class="row gy-5">
            <div class="col-lg-12">
                <div class="currency-wrapper">
                    <div class="text-start">
                        <a href="{{ route('guest.trade') }}" class="i-btn read-more-btn">Explore Markets <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">

                <x-crypto-currency-list :currencies="$currencies"/>
            </div>

           
                    
                    {{--
                    <x-crypto-currency-list :currencies="$currencies" /> --}}
               
        </div>
    </div>
</div>