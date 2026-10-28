<?php

namespace App\Filament\Widgets;

use App\Models\House;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PropertyStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Total Properties',
                House::count()
            )
                ->description('All registered properties')
                ->descriptionIcon('heroicon-m-building-office-2'),

            Stat::make(
                'Occupied Units',
                House::where('status', 'occupied')->count()
            )
                ->description('Currently occupied')
                ->descriptionIcon('heroicon-m-home-modern'),

            Stat::make(
                'Vacant Units',
                House::where('status', 'vacant')->count()
            )
                ->description('Available for occupancy')
                ->descriptionIcon('heroicon-m-key'),
        ];
    }
}