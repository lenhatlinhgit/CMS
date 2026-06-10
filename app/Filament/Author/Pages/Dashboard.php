<?php

namespace App\Filament\Author\Pages;

use App\Filament\Author\Widgets\Author\MyPostStats;
use App\Filament\Author\Widgets\Author\RecentPostsTable;
use App\Filament\Shared\Concerns\HasViewSiteHeaderAction;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    use HasViewSiteHeaderAction;

    protected static ?string $title = 'My dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    public function getWidgets(): array
    {
        return [
            MyPostStats::class,
            RecentPostsTable::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 1;
    }
}
