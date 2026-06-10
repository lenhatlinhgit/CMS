<?php

namespace App\Filament\Editor\Pages;

use App\Filament\Editor\Widgets\Editor\PendingPostsTable;
use App\Filament\Editor\Widgets\Editor\ReviewStats;
use App\Filament\Shared\Concerns\HasViewSiteHeaderAction;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    use HasViewSiteHeaderAction;

    protected static ?string $title = 'Review desk';

    protected static ?string $navigationLabel = 'Dashboard';

    public function getWidgets(): array
    {
        return [
            ReviewStats::class,
            PendingPostsTable::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 1;
    }
}
