<?php

namespace App\Filament\Resources\CustomerCategoriesResource\Pages;

use App\Filament\Resources\CustomerCategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerCategories extends CreateRecord
{
    protected static string $resource = CustomerCategoriesResource::class;
    // protected static bool $canCreateAnother = false;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
