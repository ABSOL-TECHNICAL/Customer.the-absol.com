<?php

namespace App\Filament\Widgets;


use App\Models\CustomerSites;
use App\Models\ProcessApprovalFlow;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class BoxStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $approver =auth()->user();
        

// -------------------------------------------------tab---------------------------------------------------------------------------

        $ApprovedCustomers = CustomerSites::query()->where('status', 'approved')->count();
        $ApprovelPendingCustomers =CustomerSites::query()
            ->where('status', 'submited')
            ->where('approval_flow', ProcessApprovalFlow::where('role_id', $approver->roles->first()->id)->pluck('order')->first())->count();
        $RejectedCustomers =CustomerSites::query()->where('status', 'rejected')->count();
        $PendingWithOthersCustomers='';
        $approver = Auth::user();
                $flow=ProcessApprovalFlow::where('role_id', $approver->roles->first()->id)->pluck('order')->first();
                if($flow!=null){
                    $PendingWithOthersCustomers= CustomerSites::query()
                    ->where('status', 'submited')
                    ->where('approval_flow', '>', ProcessApprovalFlow::where('role_id', $approver->roles->first()->id)->pluck('order')->first())->count();
                }
                else{
                    $PendingWithOthersCustomers= CustomerSites::query()
                    ->where('status', 'submited')->count();
                }    
        return [
        
// --------------------------------------------------tab------------------------------------------------------------------------
        Stat::make('Total Approved Suppliers', number_format($ApprovedCustomers))
            ->description('APPROVED')
            ->descriptionIcon('heroicon-m-check-circle')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),

        Stat::make('Total Pending Suppliers', number_format($ApprovelPendingCustomers))
            ->description('PENDING') // Adjust the description and increase value as needed
            ->descriptionIcon('heroicon-m-clock')
            ->chart([5, 3, 6, 2, 10, 1, 8])
            ->color('warning'),
        
        Stat::make('Total Rejected Suppliers', number_format($RejectedCustomers))
            ->description('REJECT') // Adjust the description and increase value as needed
            ->descriptionIcon('heroicon-m-x-circle')
            ->chart([5, 3, 6, 2, 10, 1, 8])
            ->color('danger'),

        Stat::make('Pending With Others Suppliers', number_format($PendingWithOthersCustomers))
            ->description('PENDING WITH OTHERS') // Adjust the description and increase value as needed
            ->descriptionIcon('heroicon-m-clock')
            ->chart([5, 3, 6, 2, 10, 1, 8])
            ->color('info'),
        ];
    }
}
