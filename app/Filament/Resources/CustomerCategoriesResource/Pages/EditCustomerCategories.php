<?php

namespace App\Filament\Resources\CustomerCategoriesResource\Pages;

use App\Filament\Resources\CustomerCategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerCategories extends EditRecord
{
    protected static string $resource = CustomerCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
