<?php

namespace App\Filament\Resources\OrderTypeResource\Pages;

use App\Filament\Resources\OrderTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrderType extends CreateRecord
{
    protected static string $resource = OrderTypeResource::class;
    // protected static bool $canCreateAnother = false;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
