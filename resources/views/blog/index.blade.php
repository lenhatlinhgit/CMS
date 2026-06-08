<x-blog-layout title="Blog">
    <h1 class="mb-8 text-3xl font-bold text-fg-title">All posts</h1>

    <div class="space-y-6">
        @forelse ($posts as $post)
            <article class="rounded-xl border border-border bg-card p-5">
                <div class="flex flex-wrap items-center gap-2 text-xs text-fg-muted">
                    @if ($post->category)
                        <a href="{{ route('category.show', $post->category->slug) }}" class="text-primary">{{ $post->category->name }}</a>
                        <span>·</span>
                    @endif
                    <span>{{ $post->published_at?->format('M d, Y') }}</span>
                    <span>·</span>
                    <span>{{ number_format($post->views) }} views</span>
                </div>
                <h2 class="mt-2 text-2xl font-semibold">
                    <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-primary">{{ $post->title }}</a>
                </h2>
                <p class="mt-2 text-fg-muted">{{ $post->excerpt }}</p>
            </article>
        @empty
            <p class="text-fg-muted">No posts yet.</p>
        @endforelse
    </div>

    <div class="mt-8">{{ $posts->links() }}</div>
</x-blog-layout>
