<?php

namespace App\Filament\Resources\DocumentTypesResource\Pages;

use App\Filament\Resources\DocumentTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocumentTypes extends ListRecords
{
    protected static string $resource = DocumentTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
