<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'user_id',
    'category_id',
    'reviewed_by',
    'title',
    'slug',
    'excerpt',
    'content',
    'status',
    'rejection_reason',
    'views',
    'published_at',
])]
class Post extends Model
{
    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'published_at' => 'datetime',
            'views' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Post $post): void {
            if (blank($post->slug) && filled($post->title)) {
                $post->slug = static::uniqueSlug(Str::slug($post->title), $post->id);
            }
        });
    }

    public static function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base;
        $counter = 1;

        while (static::query()
            ->when($ignoreId, fn (Builder $q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PostStatus::Published);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', PostStatus::Pending);
    }

    public function submitForReview(): void
    {
        $this->update([
            'status' => PostStatus::Pending,
            'rejection_reason' => null,
        ]);
    }

    public function approve(User $reviewer): void
    {
        $this->update([
            'status' => PostStatus::Published,
            'reviewed_by' => $reviewer->id,
            'rejection_reason' => null,
            'published_at' => $this->published_at ?? now(),
        ]);
    }

    public function reject(User $reviewer, string $reason): void
    {
        $this->update([
            'status' => PostStatus::Rejected,
            'reviewed_by' => $reviewer->id,
            'rejection_reason' => $reason,
        ]);
    }

    public function recordView(): void
    {
        $key = 'viewed_post_'.$this->id;

        if (session()->has($key)) {
            return;
        }

        $this->increment('views');
        session()->put($key, true);
    }
}
