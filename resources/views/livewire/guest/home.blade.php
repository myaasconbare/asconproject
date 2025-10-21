<div>

    <livewire:guest.partials.home-hero-section />

    {{--
    <livewire:guest.partials.about-section /> --}}


    <div class="feature-details">
        <style>
            .process-item {
                background-color: #101010b3;
                backdrop-filter: blur(1.5px);
            }

            .feature-details::before {
                position: absolute;
                height: 100%;
                width: 100%;
                content: " ";
                background: url('/files/ascon-surface.jpeg');
                background-repeat: no-repeat;
                /* background-size: 100% 200%; */
                /* background-size: cover; */
                background-size: 100% 100%;
                filter: brightness(0.2);
                background-position: top;

            }

            .feature-details {
                position: relative;
            }

            @media screen and (max-width: 991px) {
                .feature-details::before {
                    background-size: 100% 100%;
                }
            }
        </style>

        <livewire:guest.partials.process-section />

        {{--
        <livewire:guest.partials.plans-section /> --}}

        <div class="service-section pt-110 pb-110 d-none">
            <div class="linear-right"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-9">
                        <div class="section-title text-center mb-60">
                            <h2>Expertise in Crypto Excellence</h2>
                            <p>Harness the full potential of cryptocurrency with our comprehensive suite of trading and
                                investment services, tailored to meet the needs of both novice and seasoned investors.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center service-tab-wrapper">
                    <div class="col-lg-6">
                        <article class="tab-pane show active" id="category_tab1">
                            <img src="{{ asset('files/service-1.jpg') }}" alt="Service image-1">
                        </article>
                        <article class="tab-pane " id="category_tab2">
                            <img src="{{ asset('files/service-2.jpg') }}" alt="Service image-2">
                        </article>
                        <article class="tab-pane " id="category_tab3">
                            <img src="{{ asset('files/service-3.jpg') }}" alt="Service image-3">
                        </article>
                        <article class="tab-pane " id="category_tab4">
                            <img src="{{ asset('files/service-4.jpg') }}" alt="Service image-4">
                        </article>
                    </div>
                    <div class="col-lg-6 ps-lg-5">
                        <nav id="myTab" class="nav nav-pills flex-column service-title-wrap">
                            <a href="#category_tab1" data-bs-toggle="pill" data-cursor="View"
                                class="active nav-link"><span>Maximize Your Returns: Best Payouts, Fund Access, and
                                    Cashback</span>
                                <i class="bi bi-arrow-right-short"></i>
                            </a>
                            <a href="#category_tab2" data-bs-toggle="pill" data-cursor="View"
                                class=" nav-link"><span>Unlock High Payouts and Cashback with 24/7 Support</span>
                                <i class="bi bi-arrow-right-short"></i>
                            </a>
                            <a href="#category_tab3" data-bs-toggle="pill" data-cursor="View"
                                class=" nav-link"><span>Top Payouts, Easy Fund Access, and Cashback Rewards</span>
                                <i class="bi bi-arrow-right-short"></i>
                            </a>
                            <a href="#category_tab4" data-bs-toggle="pill" data-cursor="View"
                                class=" nav-link"><span>Invest Smarter: High Payouts, Cashback, and Amazing
                                    Support</span>
                                <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>



    {{--
    <livewire:guest.partials.profit-calculation /> --}}

    {{--
    <livewire:guest.partials.staking-investment /> --}}

    {{--
    <livewire:guest.partials.referral-levels /> --}}

    {{--
    <livewire:guest.partials.currency-section /> --}}

    <livewire:guest.partials.predictive-section />




    {{--
    <livewire:guest.partials.service-section /> --}}


    {{--
    <livewire:guest.partials.faqs-section /> --}}

    {{--
    <livewire:guest.partials.advertise-section /> --}}

    {{--
    <livewire:guest.partials.testimonial-section /> --}}

    <livewire:guest.partials.realtime-market />

    <livewire:guest.partials.crypto-conversions />
    {{--
    <livewire:guest.partials.blog-section /> --}}

</div>