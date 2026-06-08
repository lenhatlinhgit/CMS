<?php

namespace App\Http\Controllers\Comment;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StoreCommentController extends Controller
{
    public function __invoke(Request $request, Post $post): RedirectResponse
    {
        if ($post->status !== PostStatus::Published) {
            abort(404);
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:2000'],
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
        ]);

        return redirect()
            ->route('blog.show', $post->slug)
            ->with('status', 'Comment posted.');
    }
}
