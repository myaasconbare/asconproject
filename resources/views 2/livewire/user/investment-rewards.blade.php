<div class="main-content" data-simplebar="">
    <h3 class="page-title">
        Investment Reward Badges &amp; Level: {{ auth()->user()->rewardBadge->name }}
    </h3>
    <div class="i-card-sm mt-2">
        <div class="row g-3">
            <h6 class="mb-2">
                If you have any reward badges, the background color will change.
            </h6>
            
            @foreach ($rewardBadges as  $rewardBadge)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="i-card-sm card-style dark rounded-3 {{ auth()->user()->reward_badge_id == $rewardBadge->id ? 'active' : '' }}">
                    <span class="card-active-style"></span>
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div class="text-start gap-4 mb-4">
                            <h5 class="title text-white mb-2">Level-{{ $rewardBadge->level }}</h5>
                            <p class="text-white opacity-75">{{ $rewardBadge->name }}</p>
                        </div>
                        <div class="level-badge">Reward {{ money($rewardBadge->reward) }}</div>
                    </div>

                    <div class="card-info text-center">
                        <ul class="user-card-list w-100 mb-5">
                            <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                <span class="fw-bold text-white opacity-75">Minimum Invest</span>
                                <span class="fw-bold text-white">{{ money($rewardBadge->minimum_invest) }}</span>
                            </li>
                            <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                <span class="fw-bold text-white opacity-75">Minimum Team Invest</span>
                                <span class="fw-bold text-white">{{ money($rewardBadge->minimum_team_invest) }}</span>
                            </li>
                            <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                <span class="fw-bold text-white opacity-75">Minimum Deposit</span>
                                <span class="fw-bold text-white">
                                    {{ money($rewardBadge->minimum_deposit) }}
                                </span>
                            </li>
                        </ul>
                        <p class="level-note text-white fs-15 text-start mb-0">
                            <span class="text-white bg--primary py-0 px-2 rounded-2 me-2">
                                Minimum Investment
                                Referral {{ $rewardBadge->minimum_referral_count }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>