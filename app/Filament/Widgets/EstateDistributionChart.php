<?php

namespace App\Filament\Widgets;

use App\Models\Estate;
use Filament\Widgets\ChartWidget;

class EstateDistributionChart extends ChartWidget
{
    protected ?string $heading = 'Property Distribution';

    protected ?string $description = 'Number of registered units across estates';

    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        $estates = Estate::withCount('houses')
            ->orderByDesc('houses_count')
            ->get();

        return [
            'labels' => $estates->pluck('name')->toArray(),

            'datasets' => [
                [
                    'label' => 'Units',
                    'data' => $estates->pluck('houses_count')->toArray(),

                    'backgroundColor' => '#2563EB',

                    'borderRadius' => 6,

                    'borderSkipped' => false,

                    'barPercentage' => 0.65,

                    'categoryPercentage' => 0.8,

                    'borderWidth' => 0,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',

            'responsive' => true,

            'maintainAspectRatio' => false,

            'animation' => [
                'duration' => 800,
            ],

            'plugins' => [
                'legend' => [
                    'display' => false,
                ],

                'tooltip' => [
                    'enabled' => true,

                    'displayColors' => false,

                    'padding' => 12,

                    'callbacks' => [
                        'title' => "function(context) {
                            return context[0].label;
                        }",

                        'label' => "function(context) {
                            return ' ' + context.raw + ' units';
                        }",
                    ],
                ],
            ],

            'scales' => [
                'x' => [
                    'beginAtZero' => true,

                    'border' => [
                        'display' => false,
                    ],

                    'grid' => [
                        'drawTicks' => false,
                    ],

                    'ticks' => [
                        'precision' => 0,

                        'padding' => 8,
                    ],
                ],

                'y' => [
                    'border' => [
                        'display' => false,
                    ],

                    'grid' => [
                        'display' => false,
                    ],

                    'ticks' => [
                        'padding' => 12,

                        'autoSkip' => false,
                    ],
                ],
            ],
        ];
    }
}
