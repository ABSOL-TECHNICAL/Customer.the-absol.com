<?php

namespace App\Filament\Resources\DocumentTypesResource\Pages;

use App\Filament\Resources\DocumentTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocumentTypes extends EditRecord
{
    protected static string $resource = DocumentTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
