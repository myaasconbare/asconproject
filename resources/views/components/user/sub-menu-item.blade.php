@props(['label', 'href', 'pattern', 'icon' => false])

@php($active = request()->routeIs($pattern))

<li class="sub-menu-item">
    <a 
        @class(['sidebar-menu-link', 'active' => $active]) 
        href="{{ route($pattern) }}" 
        {{-- wire:navigate --}}
        aria-expanded="false"
        >
        <p>{{ $label }}</p>
    </a>
</li>