<?php

namespace App\Filament\Resources\KenyaCitiesResource\Pages;

use App\Filament\Resources\KenyaCitiesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKenyaCities extends CreateRecord
{
    protected static string $resource = KenyaCitiesResource::class;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
