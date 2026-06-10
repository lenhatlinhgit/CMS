<?php

namespace App\Filament\Author\Pages;

use App\Filament\Author\Widgets\Author\MyPostStats;
use App\Filament\Author\Widgets\Author\RecentPostsTable;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
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
