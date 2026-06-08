<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->published()
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(12);

        return view('blog.index', compact('posts'));
    }

    public function show(Request $request, string $slug): View
    {
        $post = Post::query()
            ->published()
            ->with(['author', 'category', 'tags', 'comments.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        $post->recordView();

        if (! auth()->check() && $request->boolean('login')) {
            session()->put('url.intended', url()->current());
        }

        return view('blog.show', compact('post'));
    }
}
