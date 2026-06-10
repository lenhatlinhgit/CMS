<?php

namespace App\Providers\Filament\Concerns;

use Filament\Actions\Action;
use Filament\Panel;
use Filament\Support\Icons\Heroicon;

trait ConfiguresPublicSiteNavigation
{
    protected function configurePublicSiteNavigation(Panel $panel): Panel
    {
        return $panel
            ->userMenuItems([
                'site-home' => Action::make('site-home')
                    ->label('Back to site')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->url(fn (): string => route('home'))
                    ->sort(0),
            ]);
    }
}
