<?php

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@blog.test'],
            [
                'name' => 'Site Admin',
                'slug' => 'site-admin',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
            ]
        );

        $editor = User::query()->updateOrCreate(
            ['email' => 'editor@blog.test'],
            [
                'name' => 'Content Editor',
                'slug' => 'content-editor',
                'password' => Hash::make('password'),
                'role' => UserRole::Editor,
            ]
        );

        $author = User::query()->updateOrCreate(
            ['email' => 'author@blog.test'],
            [
                'name' => 'Blog Author',
                'slug' => 'blog-author',
                'password' => Hash::make('password'),
                'role' => UserRole::Author,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'reader@blog.test'],
            [
                'name' => 'Blog Reader',
                'slug' => 'blog-reader',
                'password' => Hash::make('password'),
                'role' => UserRole::Reader,
            ]
        );

        $category = Category::query()->updateOrCreate(
            ['slug' => 'technology'],
            [
                'name' => 'Technology',
                'description' => 'Tech articles and tutorials.',
            ]
        );

        $tag = Tag::query()->updateOrCreate(
            ['slug' => 'laravel'],
            ['name' => 'Laravel']
        );

        $post = Post::query()->updateOrCreate(
            ['slug' => 'welcome-to-our-blog'],
            [
                'user_id' => $author->id,
                'category_id' => $category->id,
                'reviewed_by' => $editor->id,
                'title' => 'Welcome to our blog',
                'excerpt' => 'A quick introduction to this multi-role blog platform.',
                'content' => '<p>This is the first published post. Readers can browse without logging in, but comments require an account.</p>',
                'status' => PostStatus::Published,
                'published_at' => now()->subDay(),
                'views' => 0,
            ]
        );

        $post->tags()->sync([$tag->id]);

        Post::query()->updateOrCreate(
            ['slug' => 'draft-post-from-author'],
            [
                'user_id' => $author->id,
                'category_id' => $category->id,
                'title' => 'Draft post from author',
                'excerpt' => 'This post is still a draft.',
                'content' => '<p>Authors can save drafts before submitting for review.</p>',
                'status' => PostStatus::Draft,
                'views' => 0,
            ]
        );

        Post::query()->updateOrCreate(
            ['slug' => 'pending-review-post'],
            [
                'user_id' => $author->id,
                'category_id' => $category->id,
                'title' => 'Post waiting for editor review',
                'excerpt' => 'This post is pending approval.',
                'content' => '<p>Editors will see this in their review queue.</p>',
                'status' => PostStatus::Pending,
                'views' => 0,
            ]
        );
    }
}
