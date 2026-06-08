<x-blog-layout :title="$category->name">
    <h1 class="mb-2 text-3xl font-bold text-fg-title">{{ $category->name }}</h1>
    @if ($category->description)
        <p class="mb-8 text-fg-muted">{{ $category->description }}</p>
    @endif

    <div class="space-y-6">
        @forelse ($posts as $post)
            <article class="rounded-xl border border-border bg-card p-5">
                <h2 class="text-xl font-semibold">
                    <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-primary">{{ $post->title }}</a>
                </h2>
                <p class="mt-2 text-sm text-fg-muted">{{ $post->excerpt }}</p>
            </article>
        @empty
            <p class="text-fg-muted">No posts in this category.</p>
        @endforelse
    </div>

    <div class="mt-8">{{ $posts->links() }}</div>
</x-blog-layout>
