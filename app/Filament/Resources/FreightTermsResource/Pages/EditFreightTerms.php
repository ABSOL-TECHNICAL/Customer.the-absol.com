<?php

namespace App\Filament\Resources\FreightTermsResource\Pages;

use App\Filament\Resources\FreightTermsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFreightTerms extends EditRecord
{
    protected static string $resource = FreightTermsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
