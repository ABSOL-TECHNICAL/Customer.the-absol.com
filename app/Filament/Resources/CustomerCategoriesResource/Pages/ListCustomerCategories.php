<?php

namespace App\Filament\Resources\CustomerCategoriesResource\Pages;

use App\Filament\Resources\CustomerCategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerCategories extends ListRecords
{
    protected static string $resource = CustomerCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
