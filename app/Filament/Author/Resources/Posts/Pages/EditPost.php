<?php

namespace App\Filament\Author\Resources\Posts\Pages;

use App\Enums\PostStatus;
use App\Filament\Author\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('submitForReview')
                ->label('Submit for review')
                ->icon(Heroicon::OutlinedPaperAirplane)
                ->color('warning')
                ->requiresConfirmation()
                ->visible(fn (Post $record): bool => in_array($record->status, [PostStatus::Draft, PostStatus::Rejected], true))
                ->action(fn (Post $record) => $record->submitForReview()),
            DeleteAction::make()
                ->visible(fn (Post $record): bool => in_array($record->status, [PostStatus::Draft, PostStatus::Rejected], true)),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (in_array($this->record->status, [PostStatus::Published, PostStatus::Pending], true)) {
            unset($data['status']);
        }

        return $data;
    }
}
