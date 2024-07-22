<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    AccountType, ApproverLevel, Customer, Bank, Branch, Collector, Country, Currency, DocumentTypes, FreightTerms, CustomerCategories, PriceList, SalesRepresentative, SalesTerritory, Territory, User
};
use Spatie\Permission\Models\{
    Role, Permission
};
use App\Models\Role as AppModelsRole;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users
        $users = [
            ['name' => 'Test User', 'email' => 'jeevanrajece21@gmail.com', 'password' => bcrypt('1234')],
            ['name' => 'Admin', 'email' => 'admin@absol.com', 'password' => bcrypt('12345')],
            ['name' => 'Manisri One', 'email' => 'approver1@gmail.com', 'password' => bcrypt('12345')],
            ['name' => 'Jayasuriya Two', 'email' => 'approver2@gmail.com', 'password' => bcrypt('12345')],
            ['name' => 'Venkatesh Three', 'email' => 'approver3@gmail.com', 'password' => bcrypt('12345')],
            ['name' => 'Priya', 'email' => 'ceo@gmail.com', 'password' => bcrypt('12345')],
        ];

        foreach ($users as $user) {
            if (!User::where('email', $user['email'])->exists()) {
                User::factory()->create($user);
            }
        }

        // Assign roles to specific users
        $adminUser = User::where('email', 'admin@absol.com')->first();
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminUser->assignRole($adminRole);

        $user2 = User::where('email', 'approver1@gmail.com')->first();
        $salesRole = Role::firstOrCreate(['name' => 'Sales Person']);
        $user2->assignRole($salesRole);

        $user3 = User::where('email', 'approver2@gmail.com')->first();
        $customerCareRole = Role::firstOrCreate(['name' => 'Customer Care']);
        $user3->assignRole($customerCareRole);

        $user4 = User::where('email', 'approver3@gmail.com')->first();
        $divisionManagerRole = Role::firstOrCreate(['name' => 'Division Manager']);
        $user4->assignRole($divisionManagerRole);

        $user5 = User::where('email', 'ceo@gmail.com')->first();
        $ceoRole = Role::firstOrCreate(['name' => 'CEO']);
        $user5->assignRole($ceoRole);

        // Create a customer
        if (!Customer::where('email', 'customer@absol.com')->exists()) {
            Customer::factory()->create([
                'name' => 'Customer',
                'email' => 'customer@absol.com',
                'password' => bcrypt('12345')
            ]);
        }

        // Create document types
        $documentTypes = [
            'Certificate of Incorporation', 'Memorandum of Association (MOA)', 'Articles of Association (AOA)',
            'CR12 (Company Ownership and Directorship Confirmation)', 'Annual Return', 'Company Registration Form',
            'Change of Director/Secretary Form', 'Share Allotment Form', 'Certificate of Compliance', 'Tax Registration Certificate',
            'Board Resolution', 'Corporate Structure Diagram', 'Business License', 'Operating Agreement', 'Partnership Agreement',
            'Beneficial Ownership Declaration', 'Trade License', 'Business Name Registration Certificate',
            'Statutory Declaration of Compliance', 'Company Seal Registration Document', 'Other Documents'
        ];

        foreach ($documentTypes as $type) {
            DocumentTypes::firstOrCreate([
                'document_type_name' => $type,
            ], [
                'document_type_required' => '0',
                'document_type_status' => '1',
            ]);
        }

        // Create roles
        $roles = ['Customer Care', 'Division Manager', 'Sales Person', 'CEO', 'Credit Control Team', 'Document Viewer'];
        foreach ($roles as $role) {
            AppModelsRole::firstOrCreate(['name' => $role]);
        }

        // Create permissions
        $permissions = [
            'Delete CustomerDocuments', 'View CustomerDocuments', 'Create CustomerDocuments', 'Update CustomerDocuments',
            'Delete Role', 'View Role', 'Create Role', 'Update Role', 'Delete Permission', 'View Permission', 'Create Permission',
            'Update Permission', 'Delete PaymentTerms', 'View PaymentTerms', 'Create PaymentTerms', 'Update PaymentTerms',
            'Delete Documents', 'View Documents', 'Create Documents', 'Update Documents',  'View',
            'Reject', 'Approve', 'Verify', 'Edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $salesRole->givePermissionTo(['View', 'Edit', 'Verify', 'Approve', 'Reject']);
        $customerCareRole->givePermissionTo(['View', 'Verify', 'Approve', 'Reject']);
        $divisionManagerRole->givePermissionTo(['View', 'Verify', 'Approve', 'Reject']);
        $ceoRole->givePermissionTo(['View', 'Edit', 'Verify', 'Approve', 'Reject']);

        // Create collectors
        $collectors = [
            'Christopher Mutisya', 'Gideon Mwangeka', 'Tmothy Macharia', 'Mwangi, Ms. Bernadette',
            'Brenda Jelimo', 'Dickson Wafula', 'John Mbwika','Peter Nyamache', 'Default Collector'
        ];

        foreach ($collectors as $name) {
            Collector::firstOrCreate(['collector_name' => $name], ['collector_status' => '1']);
        }

        // Create freight terms
        $freightTerms = ['Collect',
        'Prepay & Add with cost conversion',
        'Prepay & Add',
        'Prepaid',
        'To Be Determined',
        'Third Party Billing'];
        foreach ($freightTerms as $term) {
            FreightTerms::firstOrCreate(['name' => $term]);
        }

        // Create account types
        $accountTypes = ['External', 'Internal'];
        foreach ($accountTypes as $type) {
            AccountType::firstOrCreate(['type' => $type]);
        }

        // Create customer categories
        $customerCategories = [
           'CC',
'Exports OFS',
'Federal',
'FO',
'FO Duka',
'FO VSM',
'HUB',
'IND-Dom',
'IND-Exps',
'Institutions',
'SMK',
'SMO',
'Suppliers',
'Transporter',
        ];

        foreach ($customerCategories as $category) {
            CustomerCategories::firstOrCreate(['customer_categories_name' => $category]);
        }


        //sales_territory
        $salesterrritory = [
            'Export', 'Zone 1', 'Zone 2', 'Zone 3'
        ];
        foreach ($salesterrritory as $salterr){
            SalesTerritory::firstOrCreate(['sales_territory' => $salterr]);
        }

        //sales_representative
        $salesrepresentative = [
            'Amina Muriuki','Andrew Sainare','Beatrice Mwamburi','Caroline Gachiri','Fred Shago','Hansen Ochieng',
            'Kajal Bhundia','Linet Kendi','Makoji, Mr. Benjamin','Monica Njuguna','Mwadime, Ms. Loise','Njeri, Miss Joan',
            'Peninah Muthoni'
        ];
        foreach ($salesrepresentative as $salrep){
            SalesRepresentative::firstOrCreate(['sales_representative' => $salrep]);
        }




        //pricelist
        $priceListNames = [
            "Bus Bul Trading Co. Limited",
            "CC - Coast",
            "CC - GNB",
            "CC - Loitoktok",
            "CC Central",
            "CC Eastern",
            "CC N Eastern",
            "CC Nyanza & Western",
            "CC Rift Valley",
            "CTS",
            "Chandarana",
            "Chaphole",
            "Chutzpah Limited",
            "Criss Cross",
            "DEFCO",
            "DIP",
            "Distribution CC",
            "Distribution CC1",
            "Distribution HUB",
            "EEDI",
            "FO NDC",
            "Gachanja Muhoro",
            "General Exports",
            "General Exports - EUR",
            "Guled & Victual",
            "HUB",
            "HUB N Eastern",
            "HUB -GNB",
            "HUB Central",
            "HUB Coast",
            "HUB Nyanza & Western",
            "Hub Eastern",
            "Hub Rift Valley",
            "ISO Price List",
            "Industrial-KES",
            "Industrial-USD",
            "Jambo Pay Price List",
            "Jumia Price List",
            "Kanini Haraka Ent LTD",
            "Khetia Drapers Limited",
            "Kisii Matt",
            "Linco Stores Ltd",
            "Maguna-Andu Wholesalers (K) LTD",
            "Magunas Supermarket",
            "Majid",
            "Malawi",
            "Mega Wholesalers",
            "Mesora Supermarket LTD",
            "Molo Cornermix Stores",
            "Moses Junior Distributors",
            "Mt.Kenya",
            "Naivas",
            "Nancy & Setway",
            "New Adatia Wholesalers Ltd",
            "New Maruti General Traders",
            "North Eastern Dist",
            "Ochele Price list.",
            "Ouru Superstore",
            "Pack Mat",
            "Pemba",
            "Peter Mulei & Sons LTD - Wholesale",
            "Pramukh",
            "Pwani Duka",
            "Quickmart Price List",
            "Raisons Distributors Ltd",
            "Rwanda",
            "SMK HUB",
            "Salim Ahmed Alamudi Limited",
            "Samwest",
            "Sendy Price List",
            "Shake Distributors Ltd",
            "Shariff",
            "Sojpar Ltd Price List",
            "Staff Price List",
            "Summer Price List",
            "Supermarkets-Key",
            "Supermarkets-Others",
            "Tanzania",
            "Top Line Ltd",
            "Transporters Price List",
            "Tridah Wholesalers Ltd",
            "TruFoods Purchasing Pricelist",
            "Twiga Foods Ltd",
            "Uganda"
        ];
        foreach ($priceListNames as $pricelist){
            PriceList::firstOrCreate(['Price_list_name' => $pricelist]);
        }

        // Call additional seeders
        $this->call([
            CountrySeeder::class,
            BanksSeeder::class,
            EmirateSeeder::class,
            OrderTypeSeeder::class,
            PaymentTermSeeder::class,
            CompanyTypesSeeder::class,
            CurrencySeeder::class,
            BranchesSeeder::class,
            PermissionSeeder::class,
            TerritorySeeder::class,
            SettingsTableSeeder::class
        ]);
    }
}
