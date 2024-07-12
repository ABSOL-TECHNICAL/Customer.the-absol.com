<?php

namespace App\Filament\Resources\ProcessApprovalFlowResource\Pages;

use App\Filament\Resources\ProcessApprovalFlowResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProcessApprovalFlow extends EditRecord
{
    protected static string $resource = ProcessApprovalFlowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
