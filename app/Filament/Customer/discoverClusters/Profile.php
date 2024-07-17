<?php

namespace App\Filament\Customer\discoverClusters;

use Illuminate\Support\Facades\Auth;
use App\Models\CustomerSites;
use Filament\Clusters\Cluster;

class Profile extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
 
        if ($user) {
            $customerSiteSynced = CustomerSites::where('customer_id', $user->id)
                ->value('customer_oracle_sync_site');
                // dd($supplierSiteSynced);
 
            if ($customerSiteSynced == 1) {
                return true;
            }
        }
 
        return false;
    }
}
