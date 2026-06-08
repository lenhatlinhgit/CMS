<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\CommentController as AccountCommentController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Blog\AuthorProfileController;
use App\Http\Controllers\Blog\CategoryController;
use App\Http\Controllers\Blog\HomeController;
use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\Blog\SearchController;
use App\Http\Controllers\Comment\StoreCommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('blog.show');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/author/{slug}', [AuthorProfileController::class, 'show'])->name('author.show');
Route::get('/search', SearchController::class)->name('search');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::post('/blog/{post}/comments', StoreCommentController::class)->name('comments.store');

    Route::middleware('role:reader')->prefix('account')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/comments', [AccountCommentController::class, 'index'])->name('comments');
    });
});
