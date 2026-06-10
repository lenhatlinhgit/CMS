<?php

namespace App\Filament\Admin\Widgets\Admin;

use App\Enums\PostStatus;
use App\Models\Post;
use Filament\Widgets\ChartWidget;

class PublishedTrendChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Publishing activity';

    protected ?string $description = 'Posts published in the last 7 days';

    protected ?string $maxHeight = '280px';

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 1,
    ];

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $labels = [];
        $data = [];

        for ($daysAgo = 6; $daysAgo >= 0; $daysAgo--) {
            $date = now()->subDays($daysAgo)->startOfDay();
            $labels[] = $date->format('D');
            $data[] = Post::query()
                ->where('status', PostStatus::Published)
                ->whereDate('published_at', $date)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Published',
                    'data' => $data,
                    'borderColor' => 'rgb(245, 158, 11)',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.15)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
