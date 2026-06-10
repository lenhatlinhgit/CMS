<?php

namespace App\Filament\Editor\Resources\Categories;

use App\Filament\Admin\Resources\Categories\CategoryResource as AdminCategoryResource;
use App\Filament\Editor\Resources\Categories\Pages\ManageCategories;

class CategoryResource extends AdminCategoryResource
{
    protected static string|\UnitEnum|null $navigationGroup = 'Editorial';

    protected static ?int $navigationSort = 2;

    public static function getPages(): array
    {
        return [
            'index' => ManageCategories::route('/'),
        ];
    }
}
