@assets
<link rel="stylesheet" href="{{ asset('theme/global/css/tree-view.css') }}" />
@endassets

<div class="main-content" data-simplebar="">
    <div class="i-card-sm">
        <div class="row align-items-center gy-5">
            <div class="col-xxl-12 col-xl-12 col-lg-12 order-lg-1 order-2">
                <div class="card-header">
                    <h4 class="title">Referral list</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tree-view-container">

                                @php($referralLevel = referralLevel())
                                @php($level = 1)

                                <ul class="treeview">
                                    <li class="items-expanded">
                                        {{ auth()->user()->name }} 
                                        (<a>{{ auth()->user()->email }}</a>) 
                                        <span>
                                            <i class="bi bi-activity"></i> Referral Pool <i class="bi bi-arrow-right"></i> 
                                            {{ auth()->user()->directReferrals()->count() }}
                                        </span>
                                        
                                        <x-user.partials.referral-list 
                                            :referrals="$referrals" 
                                            :level="$level"
                                        />
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script

<script src="{{ asset('theme/global/js/tree-view.js') }}"></script>

<script>
    "use strict";
    $(document).ready(function () {
        $(".tree-view").treeView();
    });
</script>

@endscript
