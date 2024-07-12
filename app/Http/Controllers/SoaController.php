<?php

namespace App\Http\Controllers;

use App\Models\Api;
use App\Models\Customer;
use App\Models\Pdf\CustomerSoa;
use App\Models\StatementOfAccounts;
use PDF;

class   SoaController extends Controller
{
    //
    public function downloadpdf(Customer $customer)
    {
        $soa = Api::statement($customer);
        // dd($soa);
        $data = [
            'date' => date('m/d/y'),
            'user' => $soa,
            'isDarkMode' => true
        ];



        $pdf = PDF::loadView('Soa', $data);

        return $pdf->download('Statement Of Account.pdf');
    }



}
