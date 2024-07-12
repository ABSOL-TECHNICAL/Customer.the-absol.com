<?php

namespace App\Filament\Resources\CustomerDocumentsResource\Pages;

use App\Filament\Resources\CustomerDocumentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomerDocuments extends ViewRecord
{
    protected static string $resource = CustomerDocumentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
