<?php

namespace App\Filament\Resources\CustomerSitesResource\Pages;

use App\Filament\Resources\CustomerSitesResource;
use App\Models\ProcessApprovalFlow;
use App\Models\CustomerSites;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\IconPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ListCustomerSites extends ListRecords
{
    protected static string $resource = CustomerSitesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {

        return [
            'All' => Tab::make()
                ->icon('heroicon-m-user-group')
                ->modifyQueryUsing(fn () => CustomerSites::whereNot('status', 'incompleted'))
                ->icon('heroicon-m-user-group')
                ->badge(fn () => CustomerSites::whereNot('status', 'incompleted')->count()),

            'Approval Pending Customer' => Tab::make('Approval Pending Customer')
                ->modifyQueryUsing(function () {
                    $approver = Auth::user();
                    return CustomerSites::query()
                        ->where('status', 'submited')                        
                        ->where('approval_flow',ProcessApprovalFlow::where('role_id', $approver->roles->first()->id)->pluck('order')->first());
                })
                ->icon('heroicon-m-user-group')
                ->badge(function () {
                    $approver = Auth::user();
                    return CustomerSites::query()
                        ->where('status', 'submited')
                        ->where('approval_flow',  ProcessApprovalFlow::where('role_id', $approver->roles->first()->id)->pluck('order')->first())->count();
                })
                ->badgeColor('warning'),

            'Approved Customer' => Tab::make('Approved Customer')
                ->icon('heroicon-m-user-group')
                ->modifyQueryUsing(function () {
                    $approver = Auth::user();
                    return CustomerSites::query()
                        ->where('status', 'approved');
                })
                ->badge(function () {
                    $approver = Auth::user();
                    return CustomerSites::query()
                        ->where('status', 'approved')->count();
                })
                ->badgeColor('success'),



            'Rejected Customer' => Tab::make('Rejected Customer')
                ->icon('heroicon-m-user-group')
                ->modifyQueryUsing(function () {
                    $approver = Auth::user();
                    return CustomerSites::where('status','rejected');
                })
                ->badge(CustomerSites::query()->where('status', 'rejected')->count())
                ->badgeColor('danger'),

                'Pending with Others' => Tab::make('Pending with Others')
                ->icon('heroicon-m-user-group')
                ->modifyQueryUsing(function () {
                    $approver = Auth::user();
                    $flow=ProcessApprovalFlow::where('role_id', $approver->roles->first()->id)->pluck('order')->first();
                    if($flow!=null){
                        return CustomerSites::query()
                        ->where('status', 'submited')
                        ->where('approval_flow', '>', ProcessApprovalFlow::where('role_id', $approver->roles->first()->id)->pluck('order')->first());
                    }
                    else{
                        return CustomerSites::query()
                        ->where('status', 'submited');
                    }    
                })
                ->badge(function () {
                    $approver = Auth::user();
                    $flow=ProcessApprovalFlow::where('role_id', $approver->roles->first()->id)->pluck('order')->first();
                    if($flow!=null){       
                        return CustomerSites::query()
                        ->where('status', 'submited')
                        ->where('approval_flow', '>', ProcessApprovalFlow::where('role_id', $approver->roles->first()->id)->pluck('order')->first())->count();
                    }
                    else{
                        return CustomerSites::query()
                        ->where('status', 'submited')->count();
                    }    
                })
                ->badgeColor('warning'),
        ];
    }
    public function getDefaultActiveTab(): string | int | null
    {
        return 'Approval Pending Customer';
    }
}
