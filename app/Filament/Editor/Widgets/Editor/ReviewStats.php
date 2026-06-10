<?php

namespace App\Filament\Editor\Widgets\Editor;

use App\Enums\PostStatus;
use App\Filament\Editor\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ReviewStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'Review queue';

    protected int|array|null $columns = [
        'default' => 1,
        'sm' => 2,
        'xl' => 4,
    ];

    protected function getStats(): array
    {
        $pendingCount = Post::query()->where('status', PostStatus::Pending)->count();
        $reviewerId = Auth::id();

        $approvedThisWeek = Post::query()
            ->where('status', PostStatus::Published)
            ->where('reviewed_by', $reviewerId)
            ->where('published_at', '>=', now()->startOfWeek())
            ->count();

        $rejectedThisWeek = Post::query()
            ->where('status', PostStatus::Rejected)
            ->where('reviewed_by', $reviewerId)
            ->where('updated_at', '>=', now()->startOfWeek())
            ->count();

        $reviewedTotal = Post::query()
            ->where('reviewed_by', $reviewerId)
            ->whereIn('status', [PostStatus::Published, PostStatus::Rejected])
            ->count();

        return [
            Stat::make('Pending review', $pendingCount)
                ->description($pendingCount > 0 ? 'Start here' : 'All caught up')
                ->descriptionIcon(Heroicon::OutlinedInboxArrowDown)
                ->icon(Heroicon::OutlinedInboxArrowDown)
                ->color($pendingCount > 0 ? 'warning' : 'success')
                ->url(PostResource::getUrl('index', ['tableFilters' => ['status' => ['value' => PostStatus::Pending->value]]])),
            Stat::make('Approved this week', $approvedThisWeek)
                ->description('Published by you')
                ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success'),
            Stat::make('Rejected this week', $rejectedThisWeek)
                ->description('Sent back to authors')
                ->descriptionIcon(Heroicon::OutlinedXCircle)
                ->icon(Heroicon::OutlinedXCircle)
                ->color('danger'),
            Stat::make('Total reviewed', $reviewedTotal)
                ->description('Approved or rejected')
                ->descriptionIcon(Heroicon::OutlinedClipboardDocumentCheck)
                ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                ->color('primary'),
        ];
    }
}
