<?php

namespace App\Filament\Admin\Widgets\Admin;

use App\Filament\Admin\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentPostsTable extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent posts')
            ->description('Latest updates across all authors')
            ->query(fn (): Builder => Post::query()->with(['author', 'category'])->latest('updated_at')->limit(5))
            ->paginated(false)
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('author.name')
                    ->label('Author'),
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
