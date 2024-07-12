<?php
 
namespace App\Http\Controllers;

use App\Models\Api;
use App\Models\Customer;
// use App\Models\CustomerAgeingReport;

use App\Models\pdf\CustomerAgeingReport; 
 
use PDF;
 
class   CustomerAgeingController extends Controller
{
    //
    public function downloadpdf(Customer $customer){
        // dd($customer);
        $customerageing = Api::agingReport($customer);
        
    //    dd()
        // dd($customer);
        // dd($customerageing);
        $data = [
            'date' => date('m/d/y'),
            'user' => $customerageing
        ];
       
   
 
        $pdf = PDF::loadView('CustomerAgeing', $data);
       
        return $pdf->download('Customer Ageing Report.pdf');
    }
 
 
   
}