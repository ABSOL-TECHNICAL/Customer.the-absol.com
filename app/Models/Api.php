<?php

namespace App\Models;

use App\Exceptions\Handler;
use Illuminate\Support\Facades\Http;
use App\Models\Customer;
use Filament\Notifications\Notification;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Api
{

    public static function chequeSummary(Customer $customer)
    {
        try {
            $customerNumber=$customer->customer_number;
            $response = Http::get('http://41.72.204.245/oracle_connector/index.php?func=OracleChequeDetailView&CID='.$customerNumber);
            return $response->json();
        } catch (\Throwable $th) {

            // return Notification::make()
            // ->color('danger')
            // ->title($th->getMessage())
            // ->send();        
        }
    }


    public static function chequeDetail(Customer $customer)
    {
        try {
            $customerNumber=$customer->customer_number;
            $response = Http::get('http://41.72.204.245/oracle_connector/index.php?func=OracleChequeDetailViewWithCustomerID&CID='.$customerNumber.'&from=1&to=100');
            // dd($response->json());
            return $response->json();
        } catch (\Throwable $th) {

            // return Notification::make()
            // ->color('danger')
            // ->title($th->getMessage())
            // ->send();        
        }
    }

    public static function chequeDetailWithDate(Customer $customer,$startDate,$endDate)
    {
        try {
            $customerNumber=$customer->customer_number;
            $response = Http::get('http://41.72.204.245/oracle_connector/index.php?func=OracleChequeDetailViewWithCustomerIDAndDate&CID='.$customerNumber.'&from=1&to=100&fromdate='.$startDate.'&todate='.$endDate);
            return $response->json();
        } catch (\Throwable $th) {

            // return Notification::make()
            // ->color('danger')
            // ->title($th->getMessage())
            // ->send();        
        }
    }
    public static function agingReport(Customer $customer)
    {
        try{
            $customerNumber=$customer->customer_number;
            $response = Http::get('http://41.72.204.245/oracle_connector/index.php?func=OracleCustomerAgingViewWithCustomerID&CID='.$customerNumber.'&from=1&to=100');
            return $response->json();
        }
        catch(\Throwable $th){

        }
    }
    public Static function statement(Customer $customer){
        try{
            $customerNumber=$customer->customer_number;
            $response = Http::get('http://41.72.204.245/oracle_connector/index.php?func=OracleCustomerAccountViewWithCustomerID&CID='.$customerNumber.'&from=1&to=100');
            return $response->json();
        }
        catch(\Throwable $th){

        }
    }
    public static function chequeSummaryWithDate(Customer $customer,$year){

        try{
            $customerNumber=$customer->customer_number;
            $response = Http::get('http://41.72.204.245/oracle_connector/index.php?func=OracleChequeSummaryViewWithCustomerID&CID='.$customerNumber.'&start_date='.$year.'&from=1&to=2000');
            return $response->json();
        }
        catch(\Throwable $th){

        }
    }
}
