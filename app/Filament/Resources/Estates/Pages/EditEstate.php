<?php

namespace App\Filament\Resources\Estates\Pages;

use App\Filament\Resources\Estates\EstateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEstate extends EditRecord
{
    protected static string $resource = EstateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
