<?php

namespace App\Filament\Resources\CompanyTypesResource\Pages;

use App\Filament\Resources\CompanyTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCompanyTypes extends CreateRecord
{
    protected static string $resource = CompanyTypesResource::class;
    // protected static bool $canCreateAnother = false;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
