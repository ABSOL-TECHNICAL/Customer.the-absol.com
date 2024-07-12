<?php

namespace App\Filament\Resources\CommunicationPersonsResource\Pages;

use App\Filament\Resources\CommunicationPersonsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCommunicationPersons extends CreateRecord
{
    protected static string $resource = CommunicationPersonsResource::class;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
