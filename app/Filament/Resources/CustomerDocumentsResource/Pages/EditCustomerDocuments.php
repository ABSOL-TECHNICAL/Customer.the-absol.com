<?php

namespace App\Filament\Resources\CustomerDocumentsResource\Pages;

use App\Filament\Resources\CustomerDocumentsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerDocuments extends EditRecord
{
    protected static string $resource = CustomerDocumentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
