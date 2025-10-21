{{-- @assets
<script src="{{ assett }}"></script>
@endassets --}}

<div class="all-coin-graph pt-110 pb-110">
    <div class="container">
        <div class="tradingview-widget-container" style="height:100%;width:100%">
            <div id="technical-analysis-chart-demo" style="height:450px;width:100%"></div>
            <script type="text/javascript" src="{{ asset('tv.js') }}"></script>
            <script type="text/javascript">
                new TradingView.widget(
                    {
                        "container_id": "technical-analysis-chart-demo",
                        "width": "100%",
                        "autosize": true,
                        "symbol": "BTC",
                        "interval": "D",
                        "timezone": "exchange",
                        "theme": "light",
                        "style": "1",
                        "withdateranges": true,
                        "hide_side_toolbar": false,
                        "allow_symbol_change": true,
                        "save_image": false,
                        "studies": [
                            "ROC@tv-basicstudies",
                            "StochasticRSI@tv-basicstudies",
                            "MASimple@tv-basicstudies"
                        ],
                        "show_popup_button": true,
                        "popup_width": "1000",
                        "popup_height": "650",
                        "support_host": "https://www.tradingview.com",
                        "locale": "en"
                    }
                );
            </script>
        </div>
    </div>
</div>
