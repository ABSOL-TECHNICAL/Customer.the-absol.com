<?php

namespace App\Filament\Resources\CustomerAnswersResource\Pages;

use App\Filament\Resources\CustomerAnswersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerAnswers extends ListRecords
{
    protected static string $resource = CustomerAnswersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
