<?php

namespace App\Filament\Resources\PaymentTermsResource\Pages;

use App\Filament\Resources\PaymentTermsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentTerms extends CreateRecord
{
    protected static string $resource = PaymentTermsResource::class;
    // protected static bool $canCreateAnother = false;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
