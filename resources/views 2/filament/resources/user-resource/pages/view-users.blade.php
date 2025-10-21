@use('\Illuminate\Support\Number', 'Number')

@assets

@endassets

<x-filament-panels::page class="p-0">
    <div class="grid grid-cols-12 gap-8 lg:scae-90" style="zoom: 0.9">
        <div class="col-span-ful col-span-4">
            <x-filament::section icon="heroicon-m-user" icon-size="md" class="p-0">
                <x-slot name="heading">
                    User details
                </x-slot>

                <div class="flex-auto p-6 pt-0">
                    <div class="flex flex-col items-center border-0 mb-4 py-4 gap-2 dark:bg-gray-800">
                        <div class="user-profile-image p-1">
                            <x-filament::avatar src="{{ $record->avatar_url }}" alt="Dan Harrin"
                                class="h-[100px] w-[100px]" />
                        </div>
                        <div class="text-center">
                            <h5 class="mb-3">
                                {{ ucFirst($record->name) }}
                            </h5>
                            <span class="inline-block fw-bold text-gray-100 mb-2 ">Joined At</span>
                            <h6 class="fw-normal text-gray-500 dark:text-gray-400">
                                {{ formatDate($record->created_at) }}
                            </h6>
                        </div>
                    </div>

                    <ul class="my-4 space-y-3 border-0">
                        <li>
                            <a href="#" wire:click="loginAsUser"
                                class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                                <x-filament::icon-button class="!text-white" icon="heroicon-m-eye"
                                     label="New label" />
                                     <span class="flex-1 ms-3 whitespace-nowrap">
                                         <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="loginAsUser" />
                                        Login As User
                                    </span>
                                {{-- <span
                                    class="inline-flex items-center justify-center px-2 py-0.5 ms-3 text-xs font-medium text-gray-500 bg-gray-200 rounded dark:bg-gray-700 dark:text-gray-400">Popular</span>
                                --}}
                            </a>
                        </li>
                        <li>
                            <a href="{{ $investmentsUrl }}"
                                class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                                <x-filament::icon-button class="!text-white" icon="heroicon-m-eye"
                                    wire:click="openNewUserModal" label="New label" />
                                <span class="flex-1 ms-3 whitespace-nowrap">
                                    Investments
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $withdrawalsUrl }}"
                                class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                                <x-filament::icon-button class="!text-white" icon="heroicon-m-eye"
                                    wire:click="openNewUserModal" label="New label" />
                                <span class="flex-1 ms-3 whitespace-nowrap">Withdrawals</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $tradesUrl }}"
                                class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                                <x-filament::icon-button class="!text-white" icon="heroicon-m-eye"
                                    wire:click="openNewUserModal" label="New label" />
                                <span class="flex-1 ms-3 whitespace-nowrap">Trade Activities</span>
                            </a>
                        </li>

                    </ul>
                </div>

            </x-filament::section>
        </div>
        <div class="col-span-full flex flex-col lg:col-span-8 gap-8">

            <x-filament::section>
                <div class="bg-gray100">
                    <div class="mx-auto py-8">
                        <div class="grid grid-cols-4 sm:grid-cols-12 gap-6 px-4">

                            <div class="col-span-full">
                                <div>
                                    <div class="relative  rounded-lg  dark:bg-gray-800" id="stats" role="tabpanel"
                                        aria-labelledby="stats-tab">
                                        <img class="relative object-cover w-full h-[150px] rounded-xl"
                                            src="https://i.imgur.com/kGkSg1v.png"
                                            style="opacity: 0.2;filter: hue-rotate(45deg);">
                                        <div class="absolute p-4 top-0">
                                            <div
                                                class="grid max-w-screen-xl grid-cols-3 gap-8  mx-auto text-gray-900  dark:text-white sm:p-8">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div class="mb-2 text-xl font-extrabold">
                                                        {{ Number::currency((float) $record->total_deposited) }}
                                                    </div>
                                                    <div class="text-gray-500 dark:text-gray-400">Total Deposited</div>
                                                </div>
                                                <div class="flex flex-col items-center justify-center">
                                                    <div class="mb-2 text-xl font-extrabold">
                                                        {{ Number::currency((float) $record->total_invested) }}
                                                    </div>
                                                    <div class="text-gray-500 dark:text-gray-400">
                                                        Total Invested
                                                    </div>
                                                </div>
                                                <div class="flex flex-col items-center justify-center">
                                                    <div class="mb-2 text-xl font-extrabold">
                                                        {{ Number::currency((float) $record->total_withdrawn) }}
                                                    </div>
                                                    <div class="text-gray-500 dark:text-gray-400">
                                                        Total Withdrawn
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class=" shadow rounded-lg flex">

                                    <div style="background-image: url(https://i.imgur.com/kGkSg1v.png);background-repeat: no-repeat;object-fit: cover;background-size: 100% 100%;"
                                        class="m-auto rounded-xl relative text-white">

                                        <div class="w-ful py-4 px-8">

                                            <div class="pt-1">
                                                <p class="font-light fw-bold">
                                                    Deposit Wallet
                                                    </h1>
                                                <p class="font-medium tracking-more-wider">
                                                    {{ Number::currency((float) $record->deposit_wallet) }}
                                                </p>
                                            </div>


                                        </div>
                                    </div>

                                    <div style="background-image: url(https://i.imgur.com/kGkSg1v.png);background-repeat: no-repeat;object-fit: cover;background-size: 100% 100%;"
                                        class="m-auto rounded-xl relative text-white">

                                        <div class="w-ful py-4 px-8">

                                            <div class="pt-1">
                                                <p class="font-light fw-bold">
                                                    Interest Wallet
                                                    </h1>
                                                <p class="font-medium tracking-more-wider">
                                                    {{ Number::currency((float) $record->interest_wallet) }}
                                                </p>
                                            </div>


                                        </div>
                                    </div>

                                    <div style="background-image: url(https://i.imgur.com/kGkSg1v.png);background-repeat: no-repeat;object-fit: cover;background-size: 100% 100%;"
                                        class="m-auto rounded-xl relative text-white">

                                        <div class="w-ful py-4 px-8">

                                            <div class="pt-1">
                                                <p class="font-light fw-bold">
                                                    Residual Wallet
                                                    </h1>
                                                <p class="font-medium tracking-more-wider">
                                                    {{ Number::currency((float) $record->residual_wallet) }}
                                                </p>
                                            </div>


                                        </div>
                                    </div>






                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">
                    Update Wallets
                </x-slot>
                {{ $this->walletsForm }}
                <x-slot name="footerActions">
                    <div align="right" class="!w-full">
                        <x-filament::button wire:click="updateWallet" type="submit">
                            <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="updateWallet" />
                            Update Wallet
                        </x-filament::button>
                    </div>
                </x-slot>
            </x-filament::section>
        </div>
    </div>

    <div>
        <x-filament::section x-key="{{ now() }}" collapsible persist-collapsed id="user-information">
            <x-slot name="heading">
                User Information
            </x-slot>

            <div x-data="user" class="flex flex-col gap-8" algn="center">
                <div class="flex">
                    <x-filament::tabs label="Content tabs">
                        <x-filament::tabs.item alpine-active="activeTab === 'balances'"
                            x-on:click="activeTab = 'balances'">
                            <div class="flex gap-2 items-center justify-center">
                                <x-filament::badge icon="heroicon-m-square-3-stack-3d" icon-position="after" />
                                Balances
                            </div>
                        </x-filament::tabs.item>

                        <x-filament::tabs.item alpine-active="activeTab === 'personal'"
                            x-on:click="activeTab = 'personal'">
                            <div class="flex gap-2 items-center justify-center">
                                <x-filament::badge icon="heroicon-m-user-group" icon-position="after" />
                                Personal Info
                            </div>
                        </x-filament::tabs.item>
                    </x-filament::tabs>
                </div>
                
                <div>
                    <template x-if="activeTab == 'personal'">
                        <div>
                            <div class="mb-4">
                                <div style="--c-50: var(--primary-50); --c-400: var(--primary-400); --c-600: var(--primary-600); display: block; visibility: visible;" class="pointer-events-auto  fi-no-notification overflow-hidden transition duration-300  rounded-xl bg-white  dark:bg-gray-900 fi-color-custom ring-0 dark:ring-0 fi-color-primar w-full">
                                    <div class="flex w-full justify-center text-sm gap-3 text-center p-4 bg-custom-50 dark:bg-custom-400/5 !text-[rgba(var(--c-400),0.7)]">
                                        Manage and Update Accurate user Personal Information
                                    </div>
                                </div>
                            </div>
                            {{ $this->personalForm }}
                        </div>
                    </template>
                    <template x-if="activeTab == 'balances'">
                        <div>
                            <div class="mb-4">
                                <div style="--c-50: var(--primary-50); --c-400: var(--primary-400); --c-600: var(--primary-600); display: block; visibility: visible;" class="pointer-events-auto  fi-no-notification overflow-hidden transition duration-300  rounded-xl bg-white  dark:bg-gray-900 fi-color-custom ring-0 dark:ring-0 fi-color-primar w-full">
                                    <div class="flex w-full justify-center text-sm gap-3 text-center p-4 bg-custom-50 dark:bg-custom-400/5 !text-[rgba(var(--c-400),0.7)]">
                                        Manage and Update Accurate user Financial Balances
                                    </div>
                                </div>
                            </div>
                            {{ $this->balancesForm }}
                        </div>
                    </template>
                </div>
                <footer class="fi-section-footer border-t border-gray-200 dark:border-white/10 px-6 pt-4">
                    {{-- mmm --}}
                    <template x-if="activeTab == 'personal'">

                        <div align="right" class="!w-full">
                            <div>
                                <x-filament::button wire:click="updatePersonal" type="submit">
                                    <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="updatePersonal" />
                                    Update Personal Information
                                </x-filament::button>
                            </div>
                        </div>
                    </template>
                    <template x-if="activeTab == 'balances'">

                        <div align="right" class="!w-full">
                            <div>
                                <x-filament::button wire:click="updateBalance" type="submit">
                                    <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="updateBalance" />
                                    Update Balance
                                </x-filament::button>
                            </div>
                        </div>
                    </template>
                </footer>
            </div>
        </x-filament::section>
    </div>

    <div>
        <x-filament::section collapsible collapsed>
            <x-slot name="heading">
                Referrals
            </x-slot>

            <livewire:admin.user-referrals record="{{ $record->id }}" />
            {{-- {{ $this->referralTable }} --}}
        </x-filament::section>
    </div>
</x-filament-panels::page>

@script
<script>
    Alpine.data('user', () => ({
        activeTab: $wire.entangle('activeTab'),
        init(){
            // alert('mmm')
        }
    }));
</script>
@endscript