@section('auth') Forgot Password @endsection

<main x-data="forgotPassword">
    <div class="form-section white img-adjust">
        <div class="linear-center"></div>
        <div class="container-fluid px-0">
            <div class="row justify-content-center align-items-center gy-5">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 col-sm-10 position-relative">
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

                    <div class="form-wrapper">
                        <p>Forgot your password? Enter your email, and we’ll send a link to reset it.</p>
                        <form wire:submit.prevent='submit' method="POST" action="">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="email">Email</label>
                                        <input wire:model='email' type="email" id="email" name="email" value="" placeholder="Enter Email" required="" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="i-btn btn--lg btn--primary w-100" type="submit">Email Password Reset Link</button>
                                </div>
                            </div>

                            <div class="have-account">
                                <p class="mb-0">Remembered your password? <a href="{{ route('auth.login') }}">Sign In</a> here.</p>
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
        Alpine.data('forgotPassword', () => ({
           
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