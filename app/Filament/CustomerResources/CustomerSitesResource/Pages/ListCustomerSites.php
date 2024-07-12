<?php

namespace App\Filament\CustomerResources\CustomerSitesResource\Pages;

use App\Filament\CustomerResources\CustomerSitesResource;
use App\Models\CustomerSites;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerSites extends ListRecords
{
    protected static string $resource = CustomerSitesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->visible(function(){
                $count=CustomerSites::query()->where('customer_id',auth()->user()->id)->count();
                if($count==0)
                {
                    return true;
                }
                else{
                    return false;
                }
            }),
        ];
    }
}
