<?php

namespace App\Filament\Shared;

use App\Enums\PostStatus;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PostTableSchema
{
    public static function configure(Table $table, bool $showAuthor = true): Table
    {
        $columns = [
            TextColumn::make('title')
                ->searchable()
                ->sortable()
                ->limit(50),
            TextColumn::make('status')
                ->badge()
                ->sortable(),
            TextColumn::make('views')
                ->label('Views')
                ->sortable()
                ->numeric(),
            TextColumn::make('category.name')
                ->label('Category')
                ->sortable(),
            TextColumn::make('published_at')
                ->dateTime()
                ->sortable(),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];

        if ($showAuthor) {
            array_splice($columns, 1, 0, [
                TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable()
                    ->searchable(),
            ]);
        }

        return $table
            ->columns($columns)
            ->defaultSort('updated_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(PostStatus::class),
                SelectFilter::make('category')
                    ->relationship('category', 'name'),
            ]);
    }
}
