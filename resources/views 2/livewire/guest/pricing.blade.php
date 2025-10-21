<div>
    @section('breadcrumb')
        @include('guest.partials.breadcrumb', ['title' => 'Plans'])
    @endsection

    <livewire:guest.partials.plans-section/>
    <livewire:guest.partials.referral-levels>
    <livewire:guest.partials.service-section/>
    <livewire:guest.partials.realtime-market/>
    <livewire:guest.partials.faqs-section/>
</div>
