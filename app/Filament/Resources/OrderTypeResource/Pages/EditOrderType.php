<?php

namespace App\Filament\Resources\OrderTypeResource\Pages;

use App\Filament\Resources\OrderTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderType extends EditRecord
{
    protected static string $resource = OrderTypeResource::class;

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
