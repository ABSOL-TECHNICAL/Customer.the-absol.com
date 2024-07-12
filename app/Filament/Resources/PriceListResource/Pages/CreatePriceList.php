<?php

namespace App\Filament\Resources\PriceListResource\Pages;

use App\Filament\Resources\PriceListResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePriceList extends CreateRecord
{
    protected static string $resource = PriceListResource::class;
    // protected static bool $canCreateAnother = false;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
