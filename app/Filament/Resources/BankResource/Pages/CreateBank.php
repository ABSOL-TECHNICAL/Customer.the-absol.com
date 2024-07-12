<?php

namespace App\Filament\Resources\BankResource\Pages;

use App\Filament\Resources\BankResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBank extends CreateRecord
{
    protected static string $resource = BankResource::class;
    protected static bool $canCreateAnother = false;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
