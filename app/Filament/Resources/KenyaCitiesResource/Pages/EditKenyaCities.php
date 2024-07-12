<?php

namespace App\Filament\Resources\KenyaCitiesResource\Pages;

use App\Filament\Resources\KenyaCitiesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKenyaCities extends EditRecord
{
    protected static string $resource = KenyaCitiesResource::class;

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
