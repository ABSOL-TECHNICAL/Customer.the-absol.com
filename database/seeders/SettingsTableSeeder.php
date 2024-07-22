<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        Setting::updateOrCreate(
            ['key' => 'form_field_required'],
            ['value' => '1', 'field_name' => 'Form Field']
        );

        Setting::updateOrCreate(['key' => 'name_field_required'], ['value' => '1', 'field_name' => 'Name']);
        Setting::updateOrCreate(['key' => 'email_field_required'], ['value' => '1', 'field_name' => 'Email']);
        Setting::updateOrCreate(['key' => 'nearest_landmark'], ['value' => '1', 'field_name' => 'Nearest Landmark']);
        Setting::updateOrCreate(['key' => 'postal_code'], ['value' => '1', 'field_name' => 'Postal Code']);
        Setting::updateOrCreate(['key' => 'company_landline_number'], ['value' => '', 'field_name' => 'Company Landline Number']);
        Setting::updateOrCreate(['key' => 'site_name'], ['value' => '1', 'field_name' => 'Site Name']);
        Setting::updateOrCreate(['key' => 'location_name'], ['value' => '1', 'field_name' => 'Location Name']);
        Setting::updateOrCreate(['key' => 'website'], ['value' => '', 'field_name' => 'Website']);
        Setting::updateOrCreate(['key' => 'group_company'], ['value' => '', 'field_name' => 'Group Company']);
        Setting::updateOrCreate(['key' => 'name_of_the_company'], ['value' => '1', 'field_name' => 'Name of the Company']);
        Setting::updateOrCreate(['key' => 'currency'], ['value' => '1', 'field_name' => 'Currency']);
        Setting::updateOrCreate(['key' => 'bank'], ['value' => '1', 'field_name' => 'Bank']);
        Setting::updateOrCreate(['key' => 'account_number'], ['value' => '1', 'field_name' => 'Account Number']);
        Setting::updateOrCreate(['key' => 'bank_code'], ['value' => '1', 'field_name' => 'Bank Code']);
        Setting::updateOrCreate(['key' => 'iban'], ['value' => '', 'field_name' => 'IBAN']);
        Setting::updateOrCreate(['key' => 'country'], ['value' => '1', 'field_name' => 'Country']);
        Setting::updateOrCreate(['key' => 'statement'], ['value' => '1', 'field_name' => 'Statement']);
        Setting::updateOrCreate(['key' => 'swift'], ['value' => '1', 'field_name' => 'SWIFT']);
        Setting::updateOrCreate(['key' => 'banking_facilities'], ['value' => '1', 'field_name' => 'Banking Facilities']);
        Setting::updateOrCreate(['key' => 'auditor_name'], ['value' => '', 'field_name' => 'Auditor Name']);
        Setting::updateOrCreate(['key' => 'contact_person_name'], ['value' => '1', 'field_name' => 'Contact Person Name']);
        Setting::updateOrCreate(['key' => 'finance_email_address'], ['value' => '', 'field_name' => 'Finance Email Address']);
        Setting::updateOrCreate(['key' => 'telephone_number'], ['value' => '', 'field_name' => 'Telephone Number']);
        Setting::updateOrCreate(['key' => 'finance_mobile_number'], ['value' => '', 'field_name' => 'Finance Mobile Number']);
        Setting::updateOrCreate(['key' => 'contact_name'], ['value' => '1', 'field_name' => 'Contact Name']);
        Setting::updateOrCreate(['key' => 'owner_email_address'], ['value' => '', 'field_name' => 'Owner Email Address']);
        Setting::updateOrCreate(['key' => 'owner_phone_number'], ['value' => '', 'field_name' => 'Owner Phone Number']);
        Setting::updateOrCreate(['key' => 'owner_address'], ['value' => '', 'field_name' => 'Owner Address']);
        Setting::updateOrCreate(['key' => 'contact_email_address'], ['value' => '', 'field_name' => 'Contact Email Address']);
        Setting::updateOrCreate(['key' => 'contact_phone_number'], ['value' => '', 'field_name' => 'Contact Phone Number']);
        Setting::updateOrCreate(['key' => 'certificate_of_incorporation'], ['value' => '', 'field_name' => 'Certificate of Incorporation']);
        Setting::updateOrCreate(['key' => 'certificate_of_incorporation_issue_date'], ['value' => '', 'field_name' => 'Certificate of Incorporation Issue Date']);
        Setting::updateOrCreate(['key' => 'date_of_registration'], ['value' => '', 'field_name' => 'Date of Registration']);
        Setting::updateOrCreate(['key' => 'business_permit_issue_expiry_date'], ['value' => '', 'field_name' => 'Business Permit Issue Expiry Date']);
        Setting::updateOrCreate(['key' => 'business_permit_number'], ['value' => '', 'field_name' => 'Business Permit Number']);
        Setting::updateOrCreate(['key' => 'pin_number'], ['value' => '1', 'field_name' => 'PIN Number']);
        Setting::updateOrCreate(['key' => 'years_in_business'], ['value' => '', 'field_name' => 'Years in Business']);
        Setting::updateOrCreate(['key' => 'tax_compliance_certificate'], ['value' => '', 'field_name' => 'Tax Compliance Certificate']);
        Setting::updateOrCreate(['key' => 'exemption_category'], ['value' => '', 'field_name' => 'Exemption Category']);
        Setting::updateOrCreate(['key' => 'certificate_of_incorporation_copy'], ['value' => '', 'field_name' => 'Certificate of Incorporation Copy']);
        Setting::updateOrCreate(['key' => 'pin_certificate_copy'], ['value' => '', 'field_name' => 'PIN Certificate Copy']);
        Setting::updateOrCreate(['key' => 'business_permit_copy'], ['value' => '', 'field_name' => 'Business Permit Copy']);
        Setting::updateOrCreate(['key' => 'cr12_documents'], ['value' => '', 'field_name' => 'CR12 Documents']);
        Setting::updateOrCreate(['key' => 'document_type_status'], ['value' => '', 'field_name' => 'Document Type Status']);
        Setting::updateOrCreate(['key' => 'description'], ['value' => '', 'field_name' => 'Description']);
    }
}
