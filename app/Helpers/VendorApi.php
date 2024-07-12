<?php

namespace App\Helpers;

use App\Models\Address;
use App\Models\ApprovalComment;
use App\Models\BankInformations;
use App\Models\Collector;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerSites;
use App\Models\Financials;
use App\Models\FreightTerms;
use App\Models\LegalInformations;
use App\Models\PaymentTerms;
use App\Models\PhysicalInformations;
use App\Models\Territory;
use App\Models\KenyaCities;
use App\Models\AccountType;
use App\Models\CustomerCategories;
use App\Models\OrderType;
use App\Models\PriceList;
use App\Models\SalesRepresentative;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class VendorApi
{
    protected static $api_url = 'http://41.72.204.245/customer_dev_oracle_connector/index.php';
    
    protected static function getMimeType($extension)
    {
        $mimeTypes = [
            'xls' => 'application/vnd.ms-excel',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'pdf' => 'application/pdf',
            'gif' => 'image/gif',
            'png' => 'image/png',
            'doc' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        return $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';
    }


public static function create(CustomerSites $site, $attributes = [])
{
    try {
        
        
        $customer = Customer::find($site->customer_id);
        $physicalInformation = PhysicalInformations::find($site->physical_informations_id);
        $PROCESS_STATUS = $site->update_type == 0 ? 'INSERT' : 'UPDATE';
        $legalInformation = LegalInformations::find($site->legal_informations_id);
        $financial = Financials::find($site->financials_id);
        $bank = BankInformations::query()
            ->where('customer_id', $site->customer_id)
            ->where('bank_preferred', '1')
            ->first();
        $address = Address::find($site->address_id);
        $comments = ApprovalComment::query()
            ->where('customer_sites_id', $site->id)
            ->where('address_id',$site->address_id)
            ->orderBy('id','desc')
            ->first();

        $bank_details = $bank->bank_details;
        $pin_certificate = $legalInformation->pin_certificate_copy;
        $business_permit = $legalInformation->business_permit_copy;
        $cr12 = $legalInformation->cr12_documents;
        $coi = $legalInformation->certificate_of_incorporation_copy;
        $statement = $legalInformation->statement;
        $passport_photo_ceo = $legalInformation->passport_photo_ceo;
        $passport_ceo = $legalInformation->passport_ceo;

        $attributes['CUSTOMER_NAME'] = $physicalInformation->name;
        $attributes['CUST_CLASSIFICATION'] = '';
        $attributes['ACC_DESCRIPTION'] = $physicalInformation->name;
        $attributes['COUNTRY'] = Country::query()
            ->where('id', $address->country_id)
            ->value('country_name');
        $attributes['SITE_NAME'] = $address->site_name;
        $attributes['ADD_LINE1'] = $address->address_1;
        $attributes['ADD_LINE2'] = $address->address_2;
        $attributes['ADD_LINE3'] = $address->address_3;
        $attributes['ADD_LINE4'] = $address->address_4;
        $attributes['STATE'] = '';
        $attributes['POSTAL_CODE'] = $address->postal_code;
        $attributes['PAYMENT_TERMS'] = PaymentTerms::query()
            ->where('id', $comments->payment_terms_id)
            ->value('payment_term_name');
        $attributes['CURRENCY'] = 'AED';
        $attributes['EMAIL_ADDRESS'] = $physicalInformation->email;
        $attributes['CR_LIMIT'] = $comments->approved_credit_value;
        $attributes['OPERATING_UNIT'] = 'Pwani Oil Products Limited';
        $attributes['BILL_TO_SITE'] = $address->location_name;
        $attributes['SHIP_TO_SITE'] = $address->location_name;
        $attributes['SC_PERSON'] = SalesRepresentative::query()
            ->where('id', $comments->sales_representative_id)
            ->value('sales_representative');
        $attributes['ATTRIBUTE1'] = '';
        $attributes['ATTRIBUTE2'] = mb_strimwidth($legalInformation->business_permit_number,0, 30, '');
        $attributes['ATTRIBUTE3'] = mb_strimwidth($legalInformation->business_permit_issue_expiry_date,0, 30, '');
        $attributes['ATTRIBUTE4'] = $site->address_id;
        $attributes['ATTRIBUTE5'] = $site->customer_id;
        $attributes['ATTRIBUTE6'] = $site->customer_id;
        $attributes['SITE_CODE_LOCATIONS'] = $address->location_name;
        $attributes['CITY'] = KenyaCities::query()
        ->where('id', $address->kenya_cities_id)
        ->value('city');
        $attributes['PROCESS_STATUS'] ='INSERT';
        $attributes['TAX_REG_NO'] = $legalInformation->pin_number;
        $attributes['CREDIT_CHECK'] = '';
        $attributes['CREATION_DATE']=date('m/d/Y h:i:s',time());

        $attributes['SALES_TERRITORY'] = Territory::query()
            ->where('id', $address->territory_id)
            ->value('territory');
        $attributes['FREIGHT_TERM'] = FreightTerms::query()
            ->where('id', $comments->freight_terms_id)
            ->value('name');
        $attributes['CUSTOMER_CLASS'] = CustomerCategories::query()->where('id', $comments->customer_categories_id)->value('customer_categories_name');
        $attributes['CUST_TYPE'] = AccountType::query()->where('id', $comments->account_type_id)->value('type');

        //vp
       $attributes['ORDER_TYPE'] = OrderType::query()
            ->where('id', $comments->order_type_id)
            ->value('order_type');
        $attributes['PRICE_LIST_NAME'] = PriceList::query()
            ->where('id', $comments->price_list_id)
            ->value('Price_list_name');
        // $attributes['SALES_REPRESENTATIVE'] = SalesRepresentative::query()
        //     ->where('id', $comments->sales_representative_id)
        //     ->value('sales_representative');
        $attributes['COLLECTOR'] = Collector::query()
            ->where('id', $comments->collector_id)
            ->value('collector_name');            


        if ($PROCESS_STATUS != 'UPDATE') {
        $attributes['BANK_STATEMENT_TYPE'] = self::getMimeType(pathinfo($statement, PATHINFO_EXTENSION));
        $attributes['BANK_STATEMENT_FILE_NAME'] = $statement;

        $attributes['PIN_REG_CERT_FILE_NAME'] = $pin_certificate;
        $attributes['PIN_REG_CERT_TYPE'] = self::getMimeType(pathinfo($pin_certificate, PATHINFO_EXTENSION));

        $attributes['BUSINESS_PERMIT_FILE_NAME'] = $business_permit;
        $attributes['BUSINESS_PERMIT_TYPE'] = self::getMimeType(pathinfo($business_permit, PATHINFO_EXTENSION));
       
      
        $attributes['CR12_DOCUMENTS_FILE_NAME'] = $cr12;
        $attributes['CR12_DOCUMENTS_TYPE'] = self::getMimeType(pathinfo($cr12, PATHINFO_EXTENSION));

        $attributes['COI_FILE_NAME'] = $coi;
        $attributes['COI_FILE_TYPE'] = self::getMimeType(pathinfo($coi, PATHINFO_EXTENSION));

        $attributes['NATIONAL_ID_FILE_NAME'] = $bank_details;
        $attributes['NATIONAL_ID_FILE_TYPE'] = self::getMimeType(pathinfo($bank_details, PATHINFO_EXTENSION));
        
        
        $attributes['PASSPORT_FILE_NAME'] = $passport_ceo;
        $attributes['PASSPORT_FILE_TYPE'] = self::getMimeType(pathinfo($passport_ceo, PATHINFO_EXTENSION));

        $attributes['PHOTO_FILE_NAME'] = $passport_photo_ceo;
        $attributes['PHOTO_FILE_TYPE'] = self::getMimeType(pathinfo($passport_photo_ceo, PATHINFO_EXTENSION));


        // $attributes['COLLECTOR'] = '';
        // $attributes['PRICE_LIST_NAME'] = '';


        $filePaths = [
            'BANK_STATEMENT' => $legalInformation->statement,
            'PIN_REGISTRATION_CERTIFICATE' => $legalInformation->pin_certificate_copy,
            'BUSINESS_PERMIT' => $legalInformation->business_permit_copy,
            'CR12_DOCUMENTS' => $legalInformation->cr12_documents,
            'CERTIFICATE_OF_INCORPORATION' => $legalInformation->certificate_of_incorporation_copy,
            'NATIONAL_ID' => $bank->bank_details,
            'PASSPORT_DIR_OR_CEO' => $legalInformation->passport_ceo,
            'PHOTO' => $legalInformation->passport_photo_ceo,
         
        ];

        foreach ($filePaths as $key => $filePath) {
            if (!empty($filePath)) {
                $fullPath = Storage::disk('public')->path($filePath);
                if (file_exists($fullPath)) {
                    $attributes[$key] = base64_encode(file_get_contents($fullPath));
                }
            }
        }
    }
    //   dd( $attributes);   

        if (empty($attributes)) {
            throw new \Exception('Error: $attributes is empty or incomplete.');
        }

        $response = self::sendRequestToOracle($attributes);

        Log::info('Vendor API request: ' . print_r($attributes, true));
        Log::info('Vendor API response: ' . $response);

        $response = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON received from API');
        }

        if (isset($response['error'])) {
            throw new \Exception('API Error: ' . $response['error']);
        }

        return $response;
    } catch (\Exception $e) {
        Log::error('Vendor API create method error: ' . $e->getMessage());
        throw $e;
    }
}

protected static function sendRequestToOracle($attributes)
{
    $data = json_encode($attributes);
    $json_data = [
        'data' => $data
    ];
 
    $ch = curl_init(static::$api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
 
    $response = curl_exec($ch);
 
    if ($response === false) {
        throw new \Exception(curl_error($ch));
    }
 
    curl_close($ch);
 
    // Log the raw response
    Log::info('Raw API response: ' . $response);
 
    return $response;
}
}
