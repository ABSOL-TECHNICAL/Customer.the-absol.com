<?php

namespace App\Filament\Resources\CommunicationScenariosResource\Pages;

use App\Filament\Resources\CommunicationScenariosResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCommunicationScenarios extends CreateRecord
{
    protected static string $resource = CommunicationScenariosResource::class;
   // protected static bool $canCreateAnother = false;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
