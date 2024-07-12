<?php

namespace App\Filament\Resources\TerritoryResource\Pages;

use App\Filament\Resources\TerritoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTerritory extends CreateRecord
{
    protected static string $resource = TerritoryResource::class;
    // protected static bool $canCreateAnother = false;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    

}
