@section('auth') Two Factor Challange @endsection

<main x-data='challange'>
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
                        <h5 class="form-title">Two Factor Authentication</h5>
                        <form wire:submit.prevent='submit' action="">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="code">Authentication Code</label>
                                        <input wire:model='twoFactorCode' type="text" id="email" name="email" value="" placeholder="Enter Code" required="" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="i-btn btn--lg btn--primary w-100 spin-btn" type="submit">
                                        <x-spinner wire:loading.class='d-flex' wire:target='submit'/> 
                                        Verify
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
        Alpine.data('challange', () => ({
            init(){
                $wire.on('server-message', $store.utils.handleServerMsg.bind($store.utils));
            }
        }));
    </script>
@endscript
