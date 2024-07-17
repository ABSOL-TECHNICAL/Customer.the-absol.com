<?php

namespace App\Helpers;

use App\Models\Customer;
use App\Models\CustomerSites;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CustomerSync
{
    protected static $api_url = 'http://41.72.204.245/customer_dev_oracle_connector/index.php';

    /**
     * Fetch and update customer data.
     *
     * @return void
     */
    public function syncCustomers(): void
    {
        $queryParams = [
            'func' => 'getLastRow',
        ];

        try {
            $response = Http::get(self::$api_url, $queryParams);

            if ($response->successful()) {
                $rawResponse = $response->body();
                Log::info('Raw API response', ['body' => $rawResponse]);

                $customersData = json_decode($rawResponse, true);
                Log::info('Decoded API response', ['customersData' => $customersData]);

                if (json_last_error() === JSON_ERROR_NONE && is_array($customersData)) {
                    foreach ($customersData as $customerData) {
                        $this->updateCustomer($customerData);
                    }
                } else {
                    Log::error('Invalid JSON response', ['body' => $rawResponse]);
                }
            } else {
                Log::error('Failed to fetch customer data', ['status' => $response->status(), 'body' => $response->body()]);
            }
        } catch (\Throwable $th) {
            Log::error('Error occurred during customer data fetch', [
                'exception' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);
        }
    }

    /**
     * Update the customer record with the fetched data.
     *
     * @param array $customerData
     * @return void
     */
    protected function updateCustomer(array $customerData): void
    {
        // Update customer record
        $customer = Customer::where('id', $customerData['ATTRIBUTE5'])->first();

        if ($customer) {
            $customer->customer_number = $customerData['ACCOUNT_NUMBER'] ?? $customer->customer_number;
            $customer->customer_account_id = $customerData['CUST_ACCOUNT_ID'] ?? $customer->customer_account_id;
            $customer->save();

           
            $customerSite = CustomerSites::where('customer_id', $customer->id)->first();

            if ($customerSite) {
                $customerSite->customer_oracle_sync_site = 1;
                $customerSite->save();
            }
        }
    }
}
