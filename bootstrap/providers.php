<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\Filament\AuthorPanelProvider;
use App\Providers\Filament\EditorPanelProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    EditorPanelProvider::class,
    AuthorPanelProvider::class,
];
