<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Editor = 'editor';
    case Author = 'author';
    case Reader = 'reader';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Editor => 'Editor',
            self::Author => 'Author',
            self::Reader => 'Reader',
        };
    }

    public function panelPath(): ?string
    {
        return match ($this) {
            self::Admin => '/admin',
            self::Editor => '/editor',
            self::Author => '/author',
            self::Reader => null,
        };
    }
}
