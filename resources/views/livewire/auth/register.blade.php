@section('auth') Register @endsection

@assets
@vite(['resources/js/register.js'])
@endassets

<main x-data="register">
    <div class="form-section white img-adjust">
        <style>
            .form-section .form-bg3 {
                position: absolute;
                right: 0;
                top: 0;
                bottom: 0;
                max-width: 50%;
                z-index: -1;
            }

            
            .form-section .form-bg3::before {
                content: "";
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background: #0000004f;
                /* background: linear-gradient(90deg, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.6)); */
                /* backdrop-filter: blur(1px); */

            }

            .form-section .form-bg::before{
                background: transparent;
            }

            .form-section .form-bg3 img {
                height: 100%;
            }

            @media screen and (min-width: 992px) {
                body {
                    /* display: none; */
                }

                .form-wrapper2 {
                    --text-primary: #fff;
                    --text-secondary: #bcb8b8;
                }
            }

            .form-bg video {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }
        </style>
        <div class="form-bg">
            <video id="pool-video" preload="auto" autoplay loop playsinline="" src="{{ asset('files/pool.mp4') }}"
                poster="{{ asset('files/pool-poster1.png') }}">
                <source src="{{ asset('files/pool.mp4') }}" type="video/mp4" media="(min-width: 1500px)">
                <source src="{{ asset('files/pool.mp4') }}" type="video/mp4" media="(min-width: 720px)">
                <source src="{{ asset('files/pool.mp4') }}" type="video/mp4" media="(max-width: 719px)">
            </video>
            {{-- <img src="{{ asset('files/form-bg3.jpg') }}" alt="Background image" /> --}}
        </div>
        <div class="form-bg3">
            <img src="{{ asset('files/reg-skin.jpeg') }}" alt="Background image" />
        </div>
        <div class="linear-center"></div>
        <div class="container-fluid px-0">
            <div class="row justify-content-center align-items-center gy-5">
                <div class="col-xl-6 col-lg-6">
                    <div class="form-left d-md-none">
                        <a href="{{ route('guest.home') }}" class="logo not-hide-cursor" data-cursor="Home">
                            {{-- <img src="{{ asset('files/Nh7ZzZH3wQnAoPWb.png') }}" alt="Logo" /> --}}
                            <h3 class="text-white">
                                {{ config('app.name') }}
                            </h3>
                        </a>
                        <h1>Join Today &amp; Receive up to 100 USDT Bonus</h1>
                        <p>
                            Embark on a journey with {{ config('app.name') }}, where innovation meets opportunity in the
                            dynamic world of blockchain and cryptocurrency. As the market evolves with heightened
                            interest and regulatory developments, position
                            yourself for success with our advanced, secure platform. Begin your trading adventure with a
                            welcome bonus!
                        </p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-8 col-sm-10 position-relative')}}'">
                    <div class="eth-icon">
                        <img src="{{ asset('files/eth.png') }}" alt="image" />
                    </div>
                    <div class="bnb-icon">
                        <img src="{{ asset('files/bnb.png') }}" alt="image" />
                    </div>
                    <div class="ada-icon">
                        <img src="{{ asset('files/ada.png') }}" alt="image" />
                    </div>
                    <div class="sol-icon">
                        <img src="{{ asset('files/sol.png') }}" alt="image" />
                    </div>
                    <div class="form-wrapper2 login-form">
                        <h4 class="form-title">Sign Up Your Account</h4>
                        <form x-on:submit.prevent="submit" method="POST">
                            @csrf
                            <div class="row">
                                @if($this->referrer)
                                <div class="col-12">
                                    You're referred by {{ $this->referrer->name }}
                                </div>
                                @endif
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" wire:model="form.name"
                                            placeholder="Enter Name" require="" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" name="email" wire:model="form.email"
                                            placeholder="Enter Email" require="" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" name="password" wire:model="form.password"
                                            autocomplete="new-password" placeholder="Enter Password" require=""
                                            aria-autocomplete="list" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            wire:model="form.password_confirmation" autocomplete="new-password"
                                            placeholder="Enter Confirm Password" require="" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" value="Register"
                                        class="i-btn btn--lg btn--primary w-100 spin-btn">
                                        <x-spinner wire:loading.class='d-flex' wire:target='submit' />
                                        Sign Up
                                    </button>
                                </div>
                            </div>
                            {{-- <div class="another-singup">
                                <div class="or">OR</div>
                                <h6>Sign Up with</h6>

                                <div class="form-social-two">
                                    <a href="/google" class="google"><i class="bi bi-google"></i>Google</a>
                                </div>
                            </div> --}}

                            <div class="have-account">
                                <p class="mb-0">Already registered? <a href="{{ route('auth.login') }}"> Sign In</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@script
<script>
    Alpine.data('register', () => ({
            userTimezone: $wire.entangle('userTimezone'),

            async submit(){
                if(this.hasEmptyInput()) return toastr.error("Inputs can't be empty!");
                let response = await $wire.submit(); 
            },
            hasEmptyInput() {
                return [... document.querySelectorAll('.form-inner input')]
                    .some((input) => !input.value.trim())
            },
            
            init(){
                this.userTimezone = moment.tz.guess();

                $wire.on('server-message', $store.utils.handleServerMsg.bind($store.utils));
            }
        }));
</script>
@endscript