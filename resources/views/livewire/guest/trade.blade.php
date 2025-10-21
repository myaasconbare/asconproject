<div>
    @section('breadcrumb')
        @include('guest.partials.breadcrumb', ['title' => 'Trade Overview'])
    @endsection
    <livewire:guest.partials.technical-analysis-chart/>
    <livewire:guest.partials.crypto-conversions/>
    <livewire:guest.partials.crypto-price-changes/>
</div>
