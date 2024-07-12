<?php

namespace App\Filament\Resources\SalesTerritoryResource\Pages;

use App\Filament\Resources\SalesTerritoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesTerritory extends EditRecord
{
    protected static string $resource = SalesTerritoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
