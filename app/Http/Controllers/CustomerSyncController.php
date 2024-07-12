<?php
 
namespace App\Http\Controllers;
 
use App\Helpers\CustomerSync;
use Illuminate\Http\JsonResponse;
 
class CustomerSyncController extends Controller
{
    public function syncCustomers(): JsonResponse
    {
        try {
            $sync = new CustomerSync();
            $sync->syncCustomers();
 
            return response()->json([
                'message' => 'Customers synchronized successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Customer synchronization failed',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}