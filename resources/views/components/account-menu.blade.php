@php
    $user = auth()->user();
    $initials = $user
        ? collect(explode(' ', $user->name))
            ->filter()
            ->take(2)
            ->map(fn (string $part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('')
        : null;
@endphp

<div class="relative" data-dropdown>
    <button
        type="button"
        data-dropdown-trigger
        class="btn btn-sm btn-soft btn-soft-gray inline-flex items-center gap-2"
        aria-haspopup="menu"
        aria-expanded="false"
    >
        <span class="avatar-placeholder avatar-placeholder-xs rounded-full bg-bg-muted text-xs font-semibold text-fg-title">
            @if ($user)
                {{ $initials }}
            @else
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            @endif
        </span>
        <span class="hidden max-w-32 truncate sm:inline">
            {{ $user?->name ?? 'Account' }}
        </span>
        <svg class="size-4 text-fg-muted" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </button>

    <div
        data-dropdown-menu
        class="absolute end-0 top-full z-50 mt-2 hidden min-w-56 overflow-hidden rounded-xl border border-border bg-card p-1 shadow-lg"
        role="menu"
    >
        @auth
            <div class="border-b border-border px-3 py-2.5">
                <p class="truncate text-sm font-medium text-fg-title">{{ $user->name }}</p>
                <p class="truncate text-xs text-fg-muted">{{ $user->email }}</p>
            </div>

            @if ($panelPath = $user->role->panelPath())
                <a href="{{ $panelPath }}" class="account-menu-item" role="menuitem">
                    Dashboard
                </a>
            @else
                <a href="{{ route('account.index') }}" class="account-menu-item" role="menuitem">
                    My account
                </a>
                <a href="{{ route('account.profile') }}" class="account-menu-item" role="menuitem">
                    Profile
                </a>
                <a href="{{ route('account.comments') }}" class="account-menu-item" role="menuitem">
                    My comments
                </a>
            @endif

            <div class="my-1 border-t border-border"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="account-menu-item account-menu-item-danger w-full text-start" role="menuitem">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="account-menu-item" role="menuitem">
                Login
            </a>
            <a href="{{ route('register') }}" class="account-menu-item" role="menuitem">
                Register
            </a>
        @endauth
    </div>
</div>
