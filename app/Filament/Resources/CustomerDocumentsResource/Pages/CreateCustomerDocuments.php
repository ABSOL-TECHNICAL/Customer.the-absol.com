<?php

namespace App\Filament\Resources\CustomerDocumentsResource\Pages;

use App\Filament\Resources\CustomerDocumentsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerDocuments extends CreateRecord
{
    protected static string $resource = CustomerDocumentsResource::class;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
