<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class AuthorProfileController extends Controller
{
    public function show(string $slug): View
    {
        $author = User::query()->where('slug', $slug)->firstOrFail();

        $posts = $author->posts()
            ->published()
            ->latest('published_at')
            ->paginate(12);

        return view('blog.author', compact('author', 'posts'));
    }
}
