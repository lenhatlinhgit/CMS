<?php

namespace App\Filament\Editor\Resources\Categories;

use App\Filament\Admin\Resources\Categories\CategoryResource as AdminCategoryResource;
use App\Filament\Editor\Resources\Categories\Pages\ManageCategories;

class CategoryResource extends AdminCategoryResource
{
    public static function getPages(): array
    {
        return [
            'index' => ManageCategories::route('/'),
        ];
    }
}
