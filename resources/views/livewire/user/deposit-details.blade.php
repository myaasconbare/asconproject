<div class="main-content" data-simplebar="">
    <h3 class="page-title">
        Payment Preview
    </h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="i-card-sm mb-4">
                <div class="card-header">
                    {{-- <h4 class="title">New Deposit</h4> --}}
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="pricing-item card-style">
                               
    
                                <div class="header text-center">

                                    <h4 class="title text--purple mb-4 text-center">
                                        PLEASE SEND EXACTLY 
                                        <span class="text-success"> {{ $this->deposit->pay_amount }} </span>{{ strtoupper($this->deposit->currency_label) }}
                                    </h4>
                                <h4 class="title text--purple mb-4 text-center">
                                    TO
                                </h4>
                                    <span class="text-center level-badge">
                                        {{-- <span class="text-success"> --}}
                                            {{ $this->deposit->destination_wallet_address }}
                                        </span>
                                    
                                    <div class="input-group mt-4">
                                        <input type="text" id="referral-url" class="form-control reference-url" value="{{ $this->deposit->destination_wallet_address }}" aria-label="Recipient's username" aria-describedby="reference-copy" readonly="">
                                        <span class="input-group-text bg--primary text-white" id="reference-copy">Copy<i class="las la-copy ms-2"></i></span>
                                    </div>
                                </div>

                               <div class="body text-center">

                                   <div class="form-group mx-auto text-center py-4">
                                       {!!
                                       QrCode::size(200)
                                       ->margin(2)
                                       ->generate($this->deposit->destination_wallet_address);
                                       !!}
                                   </div>
   
                                   <h4 class="title text--purple mb-4 text-center">SCAN TO SEND</h4>
                                   <br>
                               </div>
                                <div class="footer">

                                    <a href="{{ route('user.deposit') }}">

                                        <button class="i-btn btn--primary btn--lg capsuled w-100 enroll-matrix-process">
                                            I have made Payment
                                            {{-- <i class="bi bi-box-arrow-up-right ms-2"></i> --}}
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>