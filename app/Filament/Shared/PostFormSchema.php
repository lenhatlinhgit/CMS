<?php

namespace App\Filament\Shared;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Tag;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostFormSchema
{
    public static function configure(Schema $schema, bool $allowStatusEdit = false, bool $allowRejectionReason = false): Schema
    {
        $components = [
            Section::make('Content')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true),
                    TextInput::make('slug')
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    Textarea::make('excerpt')
                        ->rows(3)
                        ->maxLength(500),
                    RichEditor::make('content')
                        ->required()
                        ->columnSpanFull(),
                ])
                ->columns(2),
            Section::make('Organization')
                ->schema([
                    Select::make('category_id')
                        ->label('Category')
                        ->options(fn () => Category::query()->pluck('name', 'id'))
                        ->searchable()
                        ->nullable(),
                    Select::make('tags')
                        ->relationship('tags', 'name')
                        ->multiple()
                        ->preload()
                        ->createOptionForm([
                            TextInput::make('name')->required(),
                        ]),
                ])
                ->columns(2),
        ];

        if ($allowStatusEdit) {
            $components[] = Section::make('Publishing')
                ->schema([
                    Select::make('status')
                        ->options(PostStatus::class)
                        ->required(),
                ]);
        }

        if ($allowRejectionReason) {
            $components[] = Section::make('Review')
                ->schema([
                    Textarea::make('rejection_reason')
                        ->rows(3)
                        ->columnSpanFull(),
                ]);
        }

        return $schema->components($components);
    }
}
