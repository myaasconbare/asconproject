@props(['referrals', 'level' => 1, 'depth' => 1, 'isFirst' => false])

@php($userReferrals = $referrals->where('level', 1))
@php($referralLevel = referralLevel())

<ul class="{{ $isFirst ? 'firstList' : '' }} sub-menu side-menu-dropdown collapse show">
    @foreach ($userReferrals as $userReferral)
        <li class="sub-menu-item">
            <a class="referral-single-link" href="javascript:void(0)">
                <p class="node-element" type="button" data-bs-toggle="collapse" data-bs-target="#node-ul-542" aria-expanded="true" aria-controls="node-ul-542">
                    <span><i class="bi bi-person"></i> {{ $userReferral->referred->name }} </span>
                    <span><i class="bi bi-envelope"></i> {{ $userReferral->referred->email }} @ level = {{ $depth }}</span>
                    <span><i class="bi bi-activity"></i> Referral Pool <i class="bi bi-arrow-right"></i>
                        {{ $userReferral->referred->directReferrals()->count() }}
                    </span>
                </p>
                @if($userReferral->referred->referrals()->count() && $depth <= $referralLevel- 1)
                    <x-user.partials.referral-list 
                        :referrals="$userReferral->referred->referralsWithLimit()->get()"  
                        :depth="$depth + 1"
                    />
                @endif
            </a>
        </li>
       
    @endforeach
</ul>