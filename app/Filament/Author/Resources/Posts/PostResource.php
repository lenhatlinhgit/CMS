<?php

namespace App\Filament\Author\Resources\Posts;

use App\Filament\Author\Resources\Posts\Pages\CreatePost;
use App\Filament\Author\Resources\Posts\Pages\EditPost;
use App\Filament\Author\Resources\Posts\Pages\ListPosts;
use App\Filament\Shared\PostFormSchema;
use App\Filament\Shared\PostTableSchema;
use App\Models\Post;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    protected static ?string $navigationLabel = 'My posts';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PostFormSchema::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostTableSchema::configure($table, showAuthor: false)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
