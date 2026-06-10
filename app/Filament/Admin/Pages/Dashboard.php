<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\Admin\PostsChart;
use App\Filament\Admin\Widgets\Admin\PublishedTrendChart;
use App\Filament\Admin\Widgets\Admin\RecentPostsTable;
use App\Filament\Admin\Widgets\Admin\StatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            PostsChart::class,
            PublishedTrendChart::class,
            RecentPostsTable::class,
        ];
    }

    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'lg' => 2,
        ];
    }
}
