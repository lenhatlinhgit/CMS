<?php

namespace App\Filament\Author\Resources\Posts\Pages;

use App\Enums\PostStatus;
use App\Filament\Author\Resources\Posts\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['status'] = PostStatus::Draft->value;

        return $data;
    }
}
