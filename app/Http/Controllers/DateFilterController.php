<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Api;
use Illuminate\Http\Request;

class DateFilterController extends Controller
{
    //
    public function filterDates(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Handle the date values as needed, e.g., fetch data based on the date range, etc.
        // Example: $data = Model::whereBetween('date_column', [$startDate, $endDate])->get();

        // Pass the filtered data to the view
        $response = Api::chequeDetailWithDate(auth()->user(),$startDate,$endDate);
        $data=$response->json();

        return view('filament.customer.cheque-details', compact('data'));
    }
}
