<?php

namespace App\Filament\Admin\Widgets\Admin;

use App\Enums\PostStatus;
use App\Filament\Admin\Resources\Posts\PostResource;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'Platform overview';

    protected int|array|null $columns = [
        'default' => 1,
        'sm' => 2,
        'xl' => 4,
    ];

    protected function getStats(): array
    {
        $publishedCount = Post::query()->where('status', PostStatus::Published)->count();
        $pendingCount = Post::query()->where('status', PostStatus::Pending)->count();

        return [
            Stat::make('Users', User::query()->count())
                ->description('Registered accounts')
                ->descriptionIcon(Heroicon::OutlinedUsers)
                ->icon(Heroicon::OutlinedUsers)
                ->color('primary')
                ->url(UserResource::getUrl('index')),
            Stat::make('Posts', Post::query()->count())
                ->description("{$publishedCount} published")
                ->descriptionIcon(Heroicon::OutlinedDocumentText)
                ->icon(Heroicon::OutlinedDocumentText)
                ->color('success')
                ->url(PostResource::getUrl('index')),
            Stat::make('Pending review', $pendingCount)
                ->description($pendingCount > 0 ? 'Needs editor action' : 'Queue is clear')
                ->descriptionIcon(Heroicon::OutlinedClock)
                ->icon(Heroicon::OutlinedClock)
                ->color($pendingCount > 0 ? 'warning' : 'gray')
                ->url(PostResource::getUrl('index', ['tableFilters' => ['status' => ['value' => PostStatus::Pending->value]]])),
            Stat::make('Total views', number_format(Post::query()->sum('views')))
                ->description(Comment::query()->count().' comments')
                ->descriptionIcon(Heroicon::OutlinedChatBubbleLeftRight)
                ->icon(Heroicon::OutlinedEye)
                ->color('info'),
        ];
    }
}
