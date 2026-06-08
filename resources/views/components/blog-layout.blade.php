@props(['title' => config('app.name')])

<x-layouts.base class="bg-bg text-fg min-h-screen">
    <x-slot:head>
        <title>{{ $title }} — {{ config('app.name') }}</title>
    </x-slot:head>

    <header class="border-b border-border bg-card">
        <div class="mx-auto flex max-w-5xl flex-wrap items-center justify-between gap-4 px-4 py-4">
            <a href="{{ route('home') }}" class="text-lg font-semibold text-fg-title">{{ config('app.name') }}</a>
            <nav class="flex flex-wrap items-center gap-4 text-sm">
                <a href="{{ route('blog.index') }}" class="hover:text-primary">Blog</a>
                <a href="{{ route('search') }}" class="hover:text-primary">Search</a>
                @auth
                    @if(auth()->user()->role->panelPath())
                        <a href="{{ auth()->user()->role->panelPath() }}" class="hover:text-primary">Dashboard</a>
                    @else
                        <a href="{{ route('account.index') }}" class="hover:text-primary">Account</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-primary">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-solid btn-solid-primary">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-8">
        @if (session('status'))
            <div class="mb-6 rounded-lg border border-success/30 bg-success/10 px-4 py-3 text-sm text-success">
                {{ session('status') }}
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="border-t border-border py-8 text-center text-sm text-fg-muted">
        &copy; {{ date('Y') }} {{ config('app.name') }}
    </footer>
</x-layouts.base>
