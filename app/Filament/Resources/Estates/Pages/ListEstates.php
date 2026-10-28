<?php

namespace App\Filament\Resources\Estates\Pages;

use App\Filament\Resources\Estates\EstateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEstates extends ListRecords
{
    protected static string $resource = EstateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
