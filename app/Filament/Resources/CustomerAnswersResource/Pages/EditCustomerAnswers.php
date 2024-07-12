<?php

namespace App\Filament\Resources\CustomerAnswersResource\Pages;

use App\Filament\Resources\CustomerAnswersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerAnswers extends EditRecord
{
    protected static string $resource = CustomerAnswersResource::class;

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
