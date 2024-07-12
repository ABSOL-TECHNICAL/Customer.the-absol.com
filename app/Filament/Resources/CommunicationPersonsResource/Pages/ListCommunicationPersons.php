<?php

namespace App\Filament\Resources\CommunicationPersonsResource\Pages;

use App\Filament\Resources\CommunicationPersonsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCommunicationPersons extends ListRecords
{
    protected static string $resource = CommunicationPersonsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
