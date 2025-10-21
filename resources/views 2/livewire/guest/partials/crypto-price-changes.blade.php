<div class="all-coin-section pt-110 pb-110">
    <div class="container-fluid padding-left-right">
        <div class="nav-style-three">
            <ul class="nav nav-tabs d-flex flex-row mb-40" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-one" aria-selected="false" role="tab"
                        tabindex="-1">All</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-two" aria-selected="true" role="tab">Top
                        Gainer</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-three" aria-selected="true" role="tab"
                        tabindex="-1">Top Looser</a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active show" id="tab-one" role="tabpanel">

                    <x-crypto-currency-list :currencies="$currencies" />

                    {{ $currencies->links('pagination::bootstrap-5') }}

                </div>
                <div class="tab-pane fade" id="tab-two" role="tabpanel">
                    <x-crypto-currency-list :currencies="$topGainers" />
                </div>
                <div class="tab-pane fade" id="tab-three">
                    <x-crypto-currency-list :currencies="$topLosers" />
                </div>
            </div>
        </div>
    </div>
</div>