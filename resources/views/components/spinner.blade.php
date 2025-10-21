@props(['theme' => 'light'])

<span {{ $attributes }} style="display: none;">
    <img 
    {{-- 1.5rem --}}
        @style([
            'height: 5%; width:1.5rem; vertical-align:middle;',
            // 'height: 28px; width:28px; vertical-align:middle;',
            'filter: brightness(0.2);' => $theme == 'dark'
        ]) 
        src="{{ asset('spinner.gif') }}"
    />
</span>

