<?php
 
namespace App\Http\Controllers;



use App\Models\Api;
use App\Models\Customer;
use App\Models\Pdf\ChequeStatus;
use PDF;
 
class   ChequeStatusController extends Controller
{
    //
    public function downloadpdf(Customer $customer){
        $chequestatus = Api::chequeDetail($customer);
        // dd($chequestatus);
        $data = [
            'date' => date('m/d/y'),
            'user' => $chequestatus
        ];
       
   
 
        $pdf = PDF::loadView('ChequeStatus', $data);
       
        return $pdf->download('Cheque Status Details.pdf');
    }
 
 
  
}