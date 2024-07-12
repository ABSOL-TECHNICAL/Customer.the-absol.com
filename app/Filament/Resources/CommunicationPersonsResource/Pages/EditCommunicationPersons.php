<?php

namespace App\Filament\Resources\CommunicationPersonsResource\Pages;

use App\Filament\Resources\CommunicationPersonsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCommunicationPersons extends EditRecord
{
    protected static string $resource = CommunicationPersonsResource::class;

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
