<?php

namespace App\Filament\Resources\DocumentTypesResource\Pages;

use App\Filament\Resources\DocumentTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDocumentTypes extends CreateRecord
{
    protected static string $resource = DocumentTypesResource::class;
    // protected static bool $canCreateAnother = false;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
