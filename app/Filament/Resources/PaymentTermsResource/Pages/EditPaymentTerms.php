<?php

namespace App\Filament\Resources\PaymentTermsResource\Pages;

use App\Filament\Resources\PaymentTermsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentTerms extends EditRecord
{
    protected static string $resource = PaymentTermsResource::class;

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
