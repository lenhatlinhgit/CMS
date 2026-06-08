<x-blog-layout :title="$author->name">
    <h1 class="mb-8 text-3xl font-bold text-fg-title">{{ $author->name }}</h1>

    <div class="space-y-6">
        @forelse ($posts as $post)
            <article class="rounded-xl border border-border bg-card p-5">
                <h2 class="text-xl font-semibold">
                    <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-primary">{{ $post->title }}</a>
                </h2>
                <p class="mt-2 text-sm text-fg-muted">{{ $post->excerpt }}</p>
                <p class="mt-2 text-xs text-fg-muted">{{ number_format($post->views) }} views</p>
            </article>
        @empty
            <p class="text-fg-muted">This author has no published posts.</p>
        @endforelse
    </div>

    <div class="mt-8">{{ $posts->links() }}</div>
</x-blog-layout>
