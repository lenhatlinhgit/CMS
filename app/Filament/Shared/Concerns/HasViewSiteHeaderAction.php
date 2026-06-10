<?php

namespace App\Filament\Shared\Concerns;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

trait HasViewSiteHeaderAction
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('view-site')
                ->label('View site')
                ->icon(Heroicon::OutlinedHome)
                ->url(fn (): string => route('home')),
        ];
    }
}
