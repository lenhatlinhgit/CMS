<x-blog-layout title="My account">
    <h1 class="mb-6 text-2xl font-semibold text-fg-title">Hello, {{ $user->name }}</h1>

    <div class="grid gap-4 md:grid-cols-2">
        <a href="{{ route('account.profile') }}" class="rounded-xl border border-border bg-card p-5 hover:border-primary">
            <h2 class="font-semibold">Profile</h2>
            <p class="mt-1 text-sm text-fg-muted">Update your name and email</p>
        </a>
        <a href="{{ route('account.comments') }}" class="rounded-xl border border-border bg-card p-5 hover:border-primary">
            <h2 class="font-semibold">My comments</h2>
            <p class="mt-1 text-sm text-fg-muted">{{ $commentsCount }} comments</p>
        </a>
    </div>
</x-blog-layout>
