<?php

namespace App\Filament\Resources\CommunicationScenariosResource\Pages;

use App\Filament\Resources\CommunicationScenariosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCommunicationScenarios extends EditRecord
{
    protected static string $resource = CommunicationScenariosResource::class;

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
