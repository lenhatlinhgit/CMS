<x-blog-layout title="Search">
    <h1 class="mb-6 text-3xl font-bold text-fg-title">Search</h1>

    <form method="GET" action="{{ route('search') }}" class="mb-8 flex gap-2">
        <input type="search" name="q" value="{{ $query }}" placeholder="Search posts..."
            class="flex-1 rounded-lg border border-border bg-card px-3 py-2">
        <button type="submit" class="btn btn-md btn-solid btn-solid-primary">Search</button>
    </form>

    <div class="space-y-6">
        @forelse ($posts as $post)
            <article class="rounded-xl border border-border bg-card p-5">
                <h2 class="text-xl font-semibold">
                    <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-primary">{{ $post->title }}</a>
                </h2>
                <p class="mt-2 text-sm text-fg-muted">{{ $post->excerpt }}</p>
            </article>
        @empty
            <p class="text-fg-muted">No results found.</p>
        @endforelse
    </div>

    <div class="mt-8">{{ $posts->links() }}</div>
</x-blog-layout>
