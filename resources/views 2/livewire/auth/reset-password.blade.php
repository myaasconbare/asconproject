@section('auth') Reset Password @endsection

<main x-data="resetPassword">
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
                        <h4 class="form-title">Reset Your Password</h4>
                        <form wire:submit.prevent='submit' method="POST">
                           @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="email">Email</label>
                                        <input wire:model='form.email' type="email" id="email" name="email" class="block" value="" autofocus="" placeholder="Enter Email" required="" />
                                    </div>

                                    <div class="form-inner">
                                        <label for="password">Password</label>
                                        <input wire:model='form.password' type="password" id="password" name="password" autocomplete="current-password" placeholder="Enter Password" required="" />
                                    </div>

                                    <div class="form-inner">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input wire:model='form.passwordConfirmation' type="password" id="password_confirmation" name="password_confirmation" autocomplete="current-password" placeholder="Enter your confirm password" required="" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="i-btn btn--lg btn--primary w-100" type="submit">
                                        <x-spinner wire:loading.class='d-flex' wire:target='submit'/> 
                                        Reset Password
                                    </button>
                                </div>
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
        Alpine.data('resetPassword', () => ({
            init(){
                $wire.on('server-message', $store.utils.handleServerMsg.bind($store.utils));
            }
        }));
    </script>
@endscript