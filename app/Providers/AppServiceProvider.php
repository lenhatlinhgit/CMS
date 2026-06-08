<?php

namespace App\Providers;

use Filament\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Authenticate::redirectUsing(
            fn (Request $request): string => route('login', [
                'redirect' => $request->fullUrl(),
            ])
        );
    }
}
