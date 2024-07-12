<?php

namespace App\Filament\Resources\CustomerAnswersResource\Pages;

use App\Filament\Resources\CustomerAnswersResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerAnswers extends CreateRecord
{
    protected static string $resource = CustomerAnswersResource::class;
    //protected static bool $canCreateAnother = false;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
}
