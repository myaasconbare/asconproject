@props(['label', 'href', 'pattern', 'dropdown' => false, 'icon' => false])


@php($active = $dropdown ? request()->is($pattern) : request()->routeIs($pattern))

<li class="sidebar-menu-item">
    @if($dropdown)
        <a @class(['sidebar-menu-link', 'active'=> $active])
            data-bs-toggle="collapse"
            href="#{{ $href }}"
            role="button"
            aria-controls="{{ $href }}"
            aria-expanded="{{ $active ?? false }}"
        >
            {{ $icon ?? '' }}
            <p>
                {{ $label }}
                <small><i class="las la-angle-down"></i></small>
            </p>
        </a>
    @else
        <a @class(['sidebar-menu-link', 'active'=> $active])
            href="{{ route($pattern) }}"
            {{-- wire:navigate --}}
        >
            {{ $icon ?? '' }} 
            <p>
                {{ $label }}
            </p>
        </a>
    @endif

    @if($dropdown)
        <div @class(['side-menu-dropdown collapse', 'show'=> $active]) id="{{ $href }}">
            {{ $dropdown }}
        </div>
    @endif
</li>