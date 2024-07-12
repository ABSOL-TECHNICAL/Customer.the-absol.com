<?php

namespace App\Filament\Resources\CompanyTypesResource\Pages;

use App\Filament\Resources\CompanyTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompanyTypes extends EditRecord
{
    protected static string $resource = CompanyTypesResource::class;

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
