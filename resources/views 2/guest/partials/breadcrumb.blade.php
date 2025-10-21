@props(['title'])

<div class="inner-banner img-adjust">
    <div class="linear-left"></div>
    <div class="linear-center"></div>
    <div class="linear-right"></div>
    <div class="container">
        <h2 class="inner-banner-title">
            {{ $title }}
        </h2>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('guest.home') }}">Home &nbsp; </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $title }}
                </li>
            </ol>
        </nav>
    </div>
</div>