<x-blog-layout :title="$post->title">
    <article>
        <div class="mb-4 flex flex-wrap gap-2 text-sm text-fg-muted">
            @if ($post->category)
                <a href="{{ route('category.show', $post->category->slug) }}" class="text-primary">{{ $post->category->name }}</a>
                <span>·</span>
            @endif
            <a href="{{ route('author.show', $post->author->slug) }}">{{ $post->author->name }}</a>
            <span>·</span>
            <span>{{ $post->published_at?->format('M d, Y') }}</span>
            <span>·</span>
            <span>{{ number_format($post->views) }} views</span>
        </div>

        <h1 class="text-4xl font-bold text-fg-title">{{ $post->title }}</h1>

        @if ($post->excerpt)
            <p class="mt-4 text-lg text-fg-muted">{{ $post->excerpt }}</p>
        @endif

        <div class="prose prose-neutral mt-8 max-w-none dark:prose-invert">
            {!! $post->content !!}
        </div>

        @if ($post->tags->isNotEmpty())
            <div class="mt-8 flex flex-wrap gap-2">
                @foreach ($post->tags as $tag)
                    <span class="rounded-full bg-bg-subtle px-3 py-1 text-xs">{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif
    </article>

    <section class="mt-12 border-t border-border pt-8">
        <h2 class="mb-6 text-xl font-semibold">Comments ({{ $post->comments->count() }})</h2>

        <div class="mb-8 space-y-4">
            @forelse ($post->comments as $comment)
                <div class="rounded-lg border border-border bg-card p-4">
                    <div class="mb-2 text-sm font-medium">{{ $comment->user->name }}</div>
                    <p class="text-sm text-fg">{{ $comment->body }}</p>
                    <div class="mt-2 text-xs text-fg-muted">{{ $comment->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <p class="text-sm text-fg-muted">No comments yet. Be the first!</p>
            @endforelse
        </div>

        @auth
            <form method="POST" action="{{ route('comments.store', $post) }}" class="space-y-3">
                @csrf
                <label for="body" class="block text-sm font-medium">Add a comment</label>
                <textarea id="body" name="body" rows="4" required
                    class="w-full rounded-lg border border-border bg-card px-3 py-2">{{ old('body') }}</textarea>
                @error('body')<p class="text-sm text-danger">{{ $message }}</p>@enderror
                <button type="submit" class="btn btn-md btn-solid btn-solid-primary">Post comment</button>
            </form>
        @else
            <p class="text-sm text-fg-muted">
                <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="text-primary hover:underline">Login</a>
                to leave a comment.
            </p>
        @endauth
    </section>
</x-blog-layout>
