<?php

namespace App\Filament\Resources\ProcessApprovalFlowResource\Pages;

use App\Filament\Resources\ProcessApprovalFlowResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProcessApprovalFlow extends CreateRecord
{
    protected static string $resource = ProcessApprovalFlowResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
