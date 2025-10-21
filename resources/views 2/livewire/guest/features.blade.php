<div>
    @section('breadcrumb')
        @include('guest.partials.breadcrumb', ['title' => 'Features'])
    @endsection

    <livewire:guest.partials.about-section/>

    <livewire:guest.partials.realtime-market/>

    <livewire:guest.partials.faqs-section/>

</div>
