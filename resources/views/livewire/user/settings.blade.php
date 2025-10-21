<div x-data="settings" class="main-content" data-simplebar="">
    <h3 class="page-title mb-4">Settings</h3>
    <form id="send-verification" method="post" action="/email/verification-notification">
        <input type="hidden" name="_token" value="ZyDveNXawIL2DDPM1j7DRuPYQzXeExy4KYf0dkVv" autocomplete="off">
    </form>

    <div class="i-card-sm">
        <div class="row gy-5">
            <div class="col-xl-2 col-lg-3">
                <div class="nav-style-three nav-sidebar">
                    <ul class="nav nav-tabs d-flex flex-column justify-content-start gap-lg-4 gap-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab-one" aria-selected="true"
                                role="tab">
                                <i class="bi bi-shield-check"></i>Security
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-two" aria-selected="false" role="tab"
                                tabindex="-1">
                                <i class="bi bi-info-circle"></i>General
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-10 col-lg-9 ps-lg-4">
                <div id="myTabContent3" class="tab-content">
                    <div wire:ignore.self class="tab-pane fade active show" id="tab-one" role="tabpanel">
                        <h5 class="subtitle">Security Management</h5>

                        <template wire:ignore.self x-if="!show2faForm || is2faEnabled">
                            <div class="user-form">
                                <form x-on:submit.prevent="show2faForm = true">
                                    @csrf
                                    <div class="switch-wrapper">
                                        <div class="text">
                                            <h6>Two Factor Authentication</h6>
                                            <p>Authenticating With Two Factor Authentication</p>
                                        </div>
                                        <div class="button">
                                            <button type="submit" class="i-btn btn--md btn--primary-outline capsuled">
                                                {{  auth()->user()->is_2fa_enabled ? 'Disable' : 'Enable' }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </template>
                        <template wire:ignore.self x-if="show2faForm">
                            <div class="user-form">
                                <form wire:submit.prevent='handleUser2FA' method="POST">
                                   @csrf
                                    <div class="switch-wrapper">
                                        {!!
                                            QrCode::size(200)
                                            ->margin(2)
                                            ->generate(
                                            $this->google2FA->getQRCodeUrl(
                                            config('app.name'),
                                            auth()->user()->email,
                                            $this->twoFactor->google2FASecret
                                            )
                                            );
                                            !!}
                                        <input wire:model='twoFactor.otp' type="text" id="code" name="code" placeholder="Enter code" required="">
                                        <button type="submit" class="i-btn btn--md btn--primary-outline capsuled spin-btn">
                                            <x-spinner wire:loading.class='d-flex' wire:target='handleUser2FA'/> 
                                            Confirm
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </template>

                        <div class="user-form">
                            <h5 class="subtitle mt-4">Ensure your account is using a long, random password to
                                stay secure.</h5>
                            <form method="POST" action="/password">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="current_password">Current Password <sup
                                                    class="text-danger">*</sup></label>
                                            <input wire:model='security.current_password' type="password"
                                                id="current_password" name="current_password"
                                                placeholder="Enter Current Password">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="password">New Password <sup class="text-danger">*</sup></label>
                                            <input wire:model='security.password' type="password" id="password"
                                                name="password" placeholder="Enter New Password">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="password_confirmation">Confirm Password <sup
                                                    class="text-danger">*</sup></label>
                                            <input wire:model='security.password_confirmation' type="password"
                                                id="password_confirmation" name="password_confirmation"
                                                placeholder="Enter Confirm Password">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="i-btn btn--primary btn--lg">
                                        <x-spinner wire:loading.class='d-flex' wire:target="submit('security')" />
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div wire:ignore.self class="tab-pane fade" id="tab-two" role="tabpanel">
                        <h5 class="subtitle">Profile Information</h5>
                        <form wire:submit.prevent="submit('profile')" enctype="multipart/form-data">
                            @csrf
                            <div class="user-settings mb-5">
                                <div class="row align-items-center g-4">
                                    <div class="col-lg-4">
                                        <div class="user">
                                            <label class="image">
                                                <div class="image-upload">
                                                    {{-- <input type="file" name="image"> --}}
                                                    <input x-on:change="uploadImage" type="file" class="hidden" />
                                                </div>
                                                <div class="upload-overlay">
                                                    <h6>Upload</h6>
                                                    <i class="bi bi-camera"></i>
                                                </div>

                                                {{-- <img src="default/images/1980x1080" alt="Profile image"> --}}
                                                <img x-ref="image" src="{{ auth()->user()->avatar_url }}" />
                                                {{-- <input x-on:change="uploadImage" type="file" class="hidden" /> --}}
                                        </div>
                                        <div class="content">
                                            <h6></h6>
                                            <p>Email Address: {{ auth()->user()->email }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 text-lg-end text-start">
                                    <div class="row row-cols-xl-3 row-cols-lg-2 row-cols-1 g-3">
                                        <div class="col">
                                            <div class="bg--dark p-3 rounded-2 text-start">
                                                <p class="fs-14 mb-1 ">Deposit Wallet</p>
                                                <h6 class="mb-0">{{ money(auth()->user()->deposit_wallet) }}</h6>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="bg--dark p-3 rounded-2 text-start">
                                                <p class="fs-14 mb-1 ">Interest Wallet</p>
                                                <h6 class="mb-0">{{ money(auth()->user()->interest_wallet) }}</h6>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="bg--dark p-3 rounded-2 text-start">
                                                <p class="fs-14 mb-1 ">Residual Wallet</p>
                                                <h6 class="mb-0">{{ money(auth()->user()->residual_wallet) }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="user-form">
                                <h5 class="subtitle">
                                    Update your account&#039;s profile information and email
                                    address
                                </h5>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="first_name">First Name <sup class="text-danger">*</sup></label>
                                            <input wire:model='profile.firstname' type="text" id="first_name"
                                                name="first_name" value="Gito" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="last_name">Last Name <sup class="text-danger">*</sup></label>
                                            <input wire:model='profile.lastname' type="text" id="last_name"
                                                name="last_name" value="" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="email">Email <sup class="text-danger">*</sup></label>
                                            <input wire:model='profile.email' type="email" id="email" name="email"
                                                value="demo@{{ config(" app.name") }}.test" placeholder="Enter Email">
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="phone">Phone <sup class="text-danger">*</sup></label>
                                            <input wire:model='profile.phone' type="text" id="phone" name="phone"
                                                value="" placeholder="Enter Phone">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="address">Address </label>
                                            <input wire:model='profile.address' type="text" id="address"
                                                name="meta[address][address]" value="" placeholder="Enter address">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="country">Country</label>
                                            <select id="country" wire:model='profile.country' name="country">
                                                <option value="">Select</option>
                                                @foreach ($countries as $countryCode => $country)
                                                <option value="{{ $country }}">
                                                    {{ $country }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="city">City</label>
                                            <input type="text" id="city" wire:model='profile.city' name="city" value=""
                                                placeholder="Enter City">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="postcode">Postcode</label>
                                            <input type="text" id="postcode" wire:model='profile.postcode'
                                                name="postcode" value="" placeholder="Enter Postcode">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="state">State</label>
                                            <input type="text" id="state" wire:model='profile.state' name="state"
                                                value="" placeholder="Enter State">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="i-btn btn--primary btn--lg">
                                            <x-spinner wire:loading.class='d-flex' wire:target="submit('profile')" />
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    Alpine.data('settings', () => ({
            is2faEnabled : $wire.entangle('twoFactor.is2faEnabled'),
            show2faForm : false,
            
            init(){
                $wire.on('server-message', (response) => {
                    $store.utils.handleServerMsg(response);
                    if(response[0].type == 'success'){
                       this.show2faForm = false;
                    }
                });
            },
            uploadImage(){
                let file = event.currentTarget.files[0];

                if(!file) return;
 
                Loading.standard('Uploading.. 0%');
               
                $wire.upload('image', file, async (uploadedFilename) => {
                   
                    Loading.change('Saving...');
                    
                    let response = await $wire.updateImage();

                    notifySuccess('Saved successfully');
                    
                    if(response.url) {
                        this.$refs.image.src = response.url;
                        this.showPreview = response.url;
                        document.querySelector('.user-img img').src = response.url;
                    }
                    
                }, () => {
                    hideLoading();
                    notifyError('Something went wrong');
                }, (event) => {
                    hideLoading();
                    Loading.change(`Uploading.. ${event.detail.progress}%`);
                }, () => {
                    hideLoading();
                    notifyError('Upload cancelled');
                })
            },
        }));
</script>
@endscript