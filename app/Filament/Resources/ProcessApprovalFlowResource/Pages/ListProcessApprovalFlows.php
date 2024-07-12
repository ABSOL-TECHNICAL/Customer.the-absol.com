<?php

namespace App\Filament\Resources\ProcessApprovalFlowResource\Pages;

use App\Filament\Resources\ProcessApprovalFlowResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProcessApprovalFlows extends ListRecords
{
    protected static string $resource = ProcessApprovalFlowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
