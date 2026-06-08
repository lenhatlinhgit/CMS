<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = (string) $request->string('q');

        $posts = Post::query()
            ->published()
            ->with(['author', 'category'])
            ->when(filled($query), function ($builder) use ($query) {
                $builder->where(function ($q) use ($query) {
                    $q->where('title', 'ilike', "%{$query}%")
                        ->orWhere('excerpt', 'ilike', "%{$query}%")
                        ->orWhere('content', 'ilike', "%{$query}%");
                });
            })
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('blog.search', compact('posts', 'query'));
    }
}
