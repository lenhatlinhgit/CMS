<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(): View
    {
        $comments = auth()->user()
            ->comments()
            ->with('post')
            ->latest()
            ->paginate(15);

        return view('account.comments', compact('comments'));
    }
}
