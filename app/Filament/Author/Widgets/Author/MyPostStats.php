<?php

namespace App\Filament\Author\Widgets\Author;

use App\Enums\PostStatus;
use App\Filament\Author\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class MyPostStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'My writing';

    protected int|array|null $columns = [
        'default' => 1,
        'sm' => 2,
        'xl' => 4,
    ];

    protected function getStats(): array
    {
        $posts = Post::query()->where('user_id', Auth::id());

        $publishedCount = (clone $posts)->where('status', PostStatus::Published)->count();
        $draftCount = (clone $posts)->where('status', PostStatus::Draft)->count();
        $pendingCount = (clone $posts)->where('status', PostStatus::Pending)->count();
        $rejectedCount = (clone $posts)->where('status', PostStatus::Rejected)->count();
        $totalViews = (clone $posts)->sum('views');

        return [
            Stat::make('Published', $publishedCount)
                ->description(number_format($totalViews).' total views')
                ->descriptionIcon(Heroicon::OutlinedEye)
                ->icon(Heroicon::OutlinedCheckBadge)
                ->color('success')
                ->url(PostResource::getUrl('index', ['tableFilters' => ['status' => ['value' => PostStatus::Published->value]]])),
            Stat::make('Drafts', $draftCount)
                ->description($draftCount > 0 ? 'Ready to finish' : 'No drafts')
                ->descriptionIcon(Heroicon::OutlinedPencilSquare)
                ->icon(Heroicon::OutlinedPencilSquare)
                ->color('gray')
                ->url(PostResource::getUrl('index', ['tableFilters' => ['status' => ['value' => PostStatus::Draft->value]]])),
            Stat::make('In review', $pendingCount)
                ->description('Waiting for editor')
                ->descriptionIcon(Heroicon::OutlinedClock)
                ->icon(Heroicon::OutlinedClock)
                ->color('warning'),
            Stat::make('Needs revision', $rejectedCount)
                ->description($rejectedCount > 0 ? 'Check editor feedback' : 'All good')
                ->descriptionIcon(Heroicon::OutlinedExclamationTriangle)
                ->icon(Heroicon::OutlinedExclamationTriangle)
                ->color($rejectedCount > 0 ? 'danger' : 'gray')
                ->url(PostResource::getUrl('index', ['tableFilters' => ['status' => ['value' => PostStatus::Rejected->value]]])),
        ];
    }
}
