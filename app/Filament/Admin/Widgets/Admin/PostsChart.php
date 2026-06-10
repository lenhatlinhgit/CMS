<?php

namespace App\Filament\Admin\Widgets\Admin;

use App\Enums\PostStatus;
use App\Models\Post;
use Filament\Widgets\ChartWidget;

class PostsChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Posts by status';

    protected ?string $description = 'Distribution across the editorial workflow';

    protected ?string $maxHeight = '280px';

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 1,
    ];

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $counts = collect(PostStatus::cases())
            ->mapWithKeys(fn (PostStatus $status): array => [
                $status->value => Post::query()->where('status', $status)->count(),
            ]);

        return [
            'datasets' => [
                [
                    'data' => $counts->values()->all(),
                    'backgroundColor' => [
                        'rgb(156, 163, 175)',
                        'rgb(245, 158, 11)',
                        'rgb(34, 197, 94)',
                        'rgb(239, 68, 68)',
                    ],
                ],
            ],
            'labels' => $counts->keys()->map(fn (string $status): string => PostStatus::from($status)->label())->all(),
        ];
    }
}
