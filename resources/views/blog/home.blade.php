<x-blog-layout title="Home">
    <section class="mb-10">
        <h1 class="text-3xl font-bold text-fg-title">Welcome to {{ config('app.name') }}</h1>
        <p class="mt-2 text-fg-muted">Latest stories from our authors.</p>
    </section>

    <div class="grid gap-6 md:grid-cols-2">
        @forelse ($posts as $post)
            <article class="rounded-xl border border-border bg-card p-5">
                @if ($post->category)
                    <a href="{{ route('category.show', $post->category->slug) }}" class="text-xs font-medium text-primary">
                        {{ $post->category->name }}
                    </a>
                @endif
                <h2 class="mt-2 text-xl font-semibold">
                    <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-primary">{{ $post->title }}</a>
                </h2>
                <p class="mt-2 line-clamp-3 text-sm text-fg-muted">{{ $post->excerpt }}</p>
                <div class="mt-4 flex items-center justify-between text-xs text-fg-muted">
                    <a href="{{ route('author.show', $post->author->slug) }}">{{ $post->author->name }}</a>
                    <span>{{ number_format($post->views) }} views</span>
                </div>
            </article>
        @empty
            <p class="text-fg-muted">No posts published yet.</p>
        @endforelse
    </div>

    <div class="mt-8">
        <a href="{{ route('blog.index') }}" class="btn btn-md btn-outline btn-outline-primary">View all posts</a>
    </div>
</x-blog-layout>
