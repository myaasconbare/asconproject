@section('auth') Login @endsection

<main x-data='login' wire:ignore>
    <div class="form-section white img-adjust">
        <div class="linear-center"></div>
        <div class="form-bg2">
            <img src="{{ asset('files/form-bg3.jpg') }}" alt="Background image" />
        </div>
        <div class="container-fluid px-0">
            <div class="row justify-content-center align-items-center gy-5">
                <div class="col-xl-6 col-lg-6 col-md-8 col-sm-10 position-relative">
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
                    <div class="form-wrapper2">
                        <h4 class="form-title">Access Your Trading Hub</h4>
                        <form wire:submit.prevent='submit' method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" wire:model="form.email" id="email" value="demo@{{ config("app.name") }}.test" placeholder="Enter Email" required />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" name="password" wire:model="form.password" value="user" autocomplete="current-password" placeholder="Enter Password" required />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-6">
                                        <div class="form-inner mb-sm-0 mb-3">
                                            <div class="form-group">
                                                <input type="checkbox" id="remember_me" name="remember" wire:model="form.rememeberMe" />
                                                <label for="remember_me">Remember me</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 text-sm-end text-start d-flex justify-content-sm-end justify-content-start">
                                        <div class="forgot-pass">
                                            <a href="{{ route('auth.forgot-password') }}">Forgot your password?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="i-btn btn--lg btn--primary w-100 spin-btn" type="submit">
                                        <x-spinner wire:loading.class='d-flex' wire:target='submit'/> 
                                        Sign In
                                    </button>
                                </div>
                            </div>
                            {{-- <div class="another-singup">
                                <div class="or">OR</div>
                                <h6>Sign Up with</h6>

                                <div class="form-social-two">
                                    <a href="com/google" class="google"><i class="bi bi-google"></i>Google</a>
                                </div>
                            </div> --}}

                            <div class="have-account">
                                <p class="mb-0">
                                    Don&#039;t have an account?
                                    <a href="{{ route('auth.register') }}">Sign Up</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="form-left">
                        <a href="{{ route('guest.home') }}" class="logo" data-cursor="Home">
                            <h3 class="text-white">
                                {{ config('app.name') }}
                            </h3>
                            {{-- <img src="{{ asset('files/Nh7ZzZH3wQnAoPWb.png') }}" alt="Logo" /> --}}
                        </a>
                        <h1>Step Into the World of Smart Trading</h1>
                        <p>
                            Enter the realm of {{ config("app.name") }}, where cutting-edge blockchain technology meets seamless trading experiences. As the industry evolves amidst global regulatory developments, stay ahead with our secure, intuitive
                            platform. Ready to make your mark in the dynamic world of cryptocurrency?
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@script
    <script>
        Alpine.data('login', () => ({
            async submit(){
                if(this.hasEmptyInput()) return toastr.error("Inputs can't be empty!");
                let response = await $wire.submit(); 
            },
            hasEmptyInput() {
                return [... document.querySelectorAll('.form-inner input')]
                    .some((input) => !input.value.trim())
            },
            init(){
                $successMsg = "{{ session('success') }}";
                $errorMsg = "{{ session('error') }}";

                $successMsg && notifySuccess($successMsg);
                $errorMsg && notifyError($errorMsg);

                $wire.on('server-message', $store.utils.handleServerMsg.bind($store.utils));
            }
        }));
    </script>
@endscript


