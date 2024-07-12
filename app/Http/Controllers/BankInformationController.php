<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankInformation; // Import your model if needed
use App\Models\BankInformations;
use App\Rules\OnePreferredBank;
class BankInformationController extends Controller
{
    //
      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'bank_information' => ['required', 'array', new OnePreferredBank()],
        // Add other validation rules as needed for your fields
    ]);

    // Process the form submission if validation passes
    // For example, create a new BankInformation record
    $bankInformation = BankInformations::create($validatedData['bank_information']);

    // Redirect or respond with a success message
    return redirect()->route('bank.information.index')
                     ->with('success', 'Bank information has been successfully added.');
}
}
