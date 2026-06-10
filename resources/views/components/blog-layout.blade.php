@props(['title' => config('app.name')])

<x-layouts.base class="bg-bg text-fg min-h-screen">
    <x-slot:head>
        <title>{{ $title }} — {{ config('app.name') }}</title>
    </x-slot:head>

    <header class="sticky top-0 z-50 border-b border-border bg-card/95 backdrop-blur supports-[backdrop-filter]:bg-card/80">
        <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-4 py-3">
            <a href="{{ route('home') }}" class="shrink-0 text-lg font-semibold tracking-tight text-fg-title">
                {{ config('app.name') }}
            </a>

            <div class="flex min-w-0 flex-1 items-center justify-end gap-4 sm:gap-6">
                <nav class="hidden items-center gap-1 md:flex" aria-label="Main">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-nav-link>
                    <x-nav-link :href="route('blog.index')" :active="request()->routeIs('blog.*')">Blog</x-nav-link>
                    <x-nav-link :href="route('search')" :active="request()->routeIs('search')">Search</x-nav-link>
                </nav>

                <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">
                    <x-theme-toggle />
                    <x-account-menu />
                </div>
            </div>
        </div>

        <nav class="flex gap-1 overflow-x-auto border-t border-border px-4 py-2 md:hidden" aria-label="Main">
            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-nav-link>
            <x-nav-link :href="route('blog.index')" :active="request()->routeIs('blog.*')">Blog</x-nav-link>
            <x-nav-link :href="route('search')" :active="request()->routeIs('search')">Search</x-nav-link>
        </nav>
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
