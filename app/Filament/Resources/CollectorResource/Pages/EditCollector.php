<?php

namespace App\Filament\Resources\CollectorResource\Pages;

use App\Filament\Resources\CollectorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCollector extends EditRecord
{
    protected static string $resource = CollectorResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
