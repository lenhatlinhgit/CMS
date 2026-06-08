<x-blog-layout title="My comments">
    <h1 class="mb-6 text-2xl font-semibold text-fg-title">My comments</h1>

    <div class="space-y-4">
        @forelse ($comments as $comment)
            <div class="rounded-lg border border-border bg-card p-4">
                <p class="text-sm">{{ $comment->body }}</p>
                <div class="mt-2 flex flex-wrap gap-2 text-xs text-fg-muted">
                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                    @if ($comment->post)
                        <span>·</span>
                        <a href="{{ route('blog.show', $comment->post->slug) }}" class="text-primary">View post</a>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-fg-muted">You have not commented yet.</p>
        @endforelse
    </div>

    <div class="mt-8">{{ $comments->links() }}</div>
</x-blog-layout>
