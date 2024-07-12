<?php

namespace App\Filament\Resources\FreightTermsResource\Pages;

use App\Filament\Resources\FreightTermsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFreightTerms extends ListRecords
{
    protected static string $resource = FreightTermsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
