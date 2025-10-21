<script>
    'use strict';
    $(document).on('submit', '.subscribe-form', function(e) {
        e.preventDefault();
        const email = $("#email_subscribe").val();
        if (email) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": "ZyDveNXawIL2DDPM1j7DRuPYQzXeExy4KYf0dkVv",
                },
                url: "/subscribes",
                method: "POST",
                data: {
                    email: email
                },
                success: function(response) {
                    notify('success', response.success);
                    $("#email_subscribe").val('');
                },
                error: function(response) {
                    const errorMessage = response.responseJSON ? response.responseJSON.error : "An error occurred.";
                    notify('error', errorMessage);
                }
            });
        } else {
            notify('error', "Please Input Your Email");
        }
    });
</script>

<footer class="pt-80 position-relative">
    <div class="footer-vector">
        <img src="{{ asset('files/LNCIpnEA03bOJYMm.png') }}" alt="Vector Image">
    </div>
    <div class="container">
        <div class="row align-items-end mb-60 gy-4">
            <div class="col-lg-7 pe-lg-5">
                <div class="footer-logo mb-4">
                    <h3 class="text-white">
                        {{ config('app.name') }}
                    </h3>
                    {{-- <img src="{{ asset('files/Nh7ZzZH3wQnAoPWb-1.png') }}" alt="white logo"> --}}
                </div>
                <h5 class="footer-title mb-0">Subscribe to our newsletter for the latest crypto trends, {{ config("app.name") }} updates, and exclusive insights.</h5>
            </div>

            <div class="col-lg-5">
                <div class="newsletter-box row align-items-center g-4">
                    <form class="subscribe-form" method="POST">
                        <div class="input-wrapper">
                            <input type="email" id="email_subscribe" placeholder="Your Email Address" required="">
                            <button><i class="bi bi-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row gy-5">
            <div class="col-lg-5 col-md-12 pe-lg-5">
                <p class="mb-5">{{ config("app.name") }} is your trusted partner in navigating the crypto world. We&#039;re here to assist you 24/7 with any queries and provide support for your trading and investment needs. Discover more about us, access our help center, and follow our social channels for the latest updates and insights.</p>
                <div class="payment-logos">
                    <img src="{{ asset('files/MKncljKSCMxHGGPO.png') }}" alt="image">
                </div>
            </div>

            <div class="col-lg-2 col-md-6 col-6">
                <h5 class="footer-title">Important Link</h5>
                <ul class="footer-menu">
                    <li><a href="{{ route('guest.home') }}">Home</a></li>
                    <li><a href="{{ route('guest.trade') }}">Trade</a></li>
                    {{-- <li><a href="{{ route('guest.pricing') }}">Pricing</a></li> --}}
                    <li><a href="{{ route('guest.features') }}">Features</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 col-6">
                <h5 class="footer-title">Quick Link</h5>
                <ul class="footer-menu">
                    <li><a href="{{ route('guest.privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('guest.terms') }}">Terms &amp; Conditions</a></li>
                    <li><a href="{{ route('guest.faqs') }}">FAQs</a></li>
                    <li><a href="{{ route('guest.contact') }}">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-3">
                <div class="footer-address-wrapper">
                    <div class="address-item d-flex gap-2">
                        <i class="bi bi-envelope text-white"></i>
                        <a class="address" href="mailto:{{ env('SUPPORT_EMAIL') }}">
                         {{ env('SUPPORT_EMAIL') }}
                        </a>
                    </div>
                    <div class="address-item d-flex gap-2">
                        <i class="bi bi-telephone text-white"></i>
                        <a class="address" href="tel:+9943453453">+9943453453</a>
                    </div>
                    <div class="address-item d-flex gap-2">
                        <i class="bi bi-geo-alt text-white"></i>
                        <div class="address">{{ env('APP_ADDRESS') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-6 text-lg-start text-center">
                    <ul class="footer-social">
                        <li><a href="https://www.facebook.com/"><i class='bi bi-facebook'></i></a></li>
                        <li><a href="https://www.twitter.com/"><i class='bi bi-twitter'></i></a></li>
                        <li><a href="https://www.instagram.com/"><i class='bi bi-instagram'></i></a></li>
                        <li><a href="https://www.tiktok.com/"><i class='bi bi-tiktok'></i></a></li>
                        <li><a href="https://www.telegram.org/"><i class='bi bi-telegram'></i></a></li>
                    </ul>
                </div>
                <div class="col-lg-6 col-lg-6 text-lg-end text-center">
                    <p>© 2024 {{ config("app.name") }}. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>