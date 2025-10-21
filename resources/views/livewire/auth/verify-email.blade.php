@section('auth') Verify Email @endsection

<main x-data="verifyEmail">
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
                        <p>Thanks for signing up! Please verify your email by clicking the link we just sent. If you didn't receive it, we'll gladly send another</p>

                        <form method="POST" wire:submit.prevent='submit'>
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <button class="i-btn btn--lg btn--primary w-100 spin-btn" type="submit">
                                        <x-spinner wire:loading.class='d-flex' wire:target='submit'/> 
                                        Resend Verification Email
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="have-account">
                            <form method="POST" wire:submit.prevent='logout'>
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary spin-btn-sm">
                                    <x-spinner wire:loading.class='d-flex' wire:target='logout' theme="dark"/>   Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@script
    <script>
        Alpine.data('verifyEmail', () => ({
            init(){
                $wire.on('server-message', $store.utils.handleServerMsg.bind($store.utils));
            }
        }));
    </script>
@endscript
