<?php

namespace App\Filament\Editor\Widgets\Editor;

use App\Enums\PostStatus;
use App\Filament\Editor\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingPostsTable extends TableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Posts awaiting review')
            ->description('Open a post to approve, reject, or request changes')
            ->query(fn (): Builder => Post::query()
                ->with(['author', 'category'])
                ->where('status', PostStatus::Pending)
                ->oldest('updated_at')
                ->limit(8))
            ->paginated(false)
            ->emptyStateHeading('No posts waiting for review')
            ->emptyStateDescription('New submissions from authors will appear here.')
            ->columns([
                TextColumn::make('title')
                    ->limit(45)
                    ->weight('medium'),
                TextColumn::make('author.name')
                    ->label('Author'),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->placeholder('—'),
                TextColumn::make('updated_at')
                    ->since()
                    ->label('Submitted'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Review')
                    ->url(fn (Post $record): string => PostResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
