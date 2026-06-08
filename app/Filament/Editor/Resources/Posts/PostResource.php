<?php

namespace App\Filament\Editor\Resources\Posts;

use App\Enums\PostStatus;
use App\Filament\Editor\Resources\Posts\Pages\EditPost;
use App\Filament\Editor\Resources\Posts\Pages\ListPosts;
use App\Filament\Shared\PostFormSchema;
use App\Filament\Shared\PostTableSchema;
use App\Models\Post;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'Review posts';

    public static function form(Schema $schema): Schema
    {
        return PostFormSchema::configure($schema, allowRejectionReason: true);
    }

    public static function table(Table $table): Table
    {
        return PostTableSchema::configure($table)
            ->recordActions([
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
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
