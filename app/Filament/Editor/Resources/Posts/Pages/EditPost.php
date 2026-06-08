<?php

namespace App\Filament\Editor\Resources\Posts\Pages;

use App\Enums\PostStatus;
use App\Filament\Editor\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (Post $record): bool => $record->status === PostStatus::Pending)
                ->action(fn (Post $record) => $record->approve(auth()->user())),
            Action::make('reject')
                ->icon(Heroicon::OutlinedXCircle)
                ->color('danger')
                ->visible(fn (Post $record): bool => $record->status === PostStatus::Pending)
                ->schema([
                    Textarea::make('rejection_reason')
                        ->label('Rejection reason')
                        ->required()
                        ->rows(3),
                ])
                ->action(function (Post $record, array $data): void {
                    $record->reject(auth()->user(), $data['rejection_reason']);
                }),
        ];
    }
}
