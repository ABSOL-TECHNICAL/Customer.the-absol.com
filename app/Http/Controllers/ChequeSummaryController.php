<?php
 
namespace App\Http\Controllers;

use App\Models\Api;
use App\Models\Customer;
use App\Models\Pdf\ChequeSummary;
use PDF;
 
class   ChequeSummaryController extends Controller
{
    //
    public function downloadpdf(Customer $customer){
        $chequesummary = Api::chequeSummary($customer);
        // dd($chequesummary);
        $data = [
            'date' => date('m/d/y'),
            'user' => $chequesummary
        ];
       
   
 
        $pdf = PDF::loadView('ChequeSummary', $data);
       
        return $pdf->download('Cheque Status Summary Details.pdf');
    }
 
 

}