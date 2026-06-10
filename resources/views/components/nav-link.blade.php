@props(['href', 'active' => false])

<a
    href="{{ $href }}"
    @class([
        'rounded-lg px-3 py-2 text-sm font-medium transition-colors',
        'bg-bg-muted text-fg-title' => $active,
        'text-fg-muted hover:bg-bg-subtle hover:text-fg-title' => ! $active,
    ])
    @if ($active) aria-current="page" @endif
>
    {{ $slot }}
</a>
