<?php

namespace App\Filament\Editor\Resources\Posts\Pages;

use App\Enums\PostStatus;
use App\Filament\Editor\Resources\Posts\PostResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->orderByRaw(
            "CASE WHEN status = ? THEN 0 ELSE 1 END",
            [PostStatus::Pending->value]
        );
    }
}
