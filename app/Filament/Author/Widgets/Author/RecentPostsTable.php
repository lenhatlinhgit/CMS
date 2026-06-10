<?php

namespace App\Filament\Author\Widgets\Author;

use App\Filament\Author\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RecentPostsTable extends TableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent posts')
            ->description('Your latest drafts and published articles')
            ->query(fn (): Builder => Post::query()
                ->where('user_id', Auth::id())
                ->latest('updated_at')
                ->limit(6))
            ->paginated(false)
            ->emptyStateHeading('No posts yet')
            ->emptyStateDescription('Create your first article to get started.')
            ->columns([
                TextColumn::make('title')
                    ->limit(45)
                    ->weight('medium'),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('views')
                    ->numeric()
                    ->label('Views'),
                TextColumn::make('updated_at')
                    ->since()
                    ->label('Updated'),
            ])
            ->recordActions([
                EditAction::make()
                    ->url(fn (Post $record): string => PostResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
