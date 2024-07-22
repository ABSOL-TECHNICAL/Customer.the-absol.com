<?php



namespace App\Filament\Resources;



use App\Enums\ApplicationStatus;

use App\Filament\Actions\ApproveAction;

use App\Filament\Actions\RejectAction;

use App\Filament\Actions\ReSubmitAction;

use App\Filament\Actions\RevokeAction;

use App\Filament\Resources\CustomerSitesResource\Pages;

use App\Filament\CustomerResources\CustomerSitesResource\RelationManagers;

use App\Models\Address;

use App\Models\ApprovalStatus;

use App\Models\Bank;

use App\Models\Branch;

use App\Models\CompanyTypes;

use App\Models\Country;

use App\Models\Currency;

use App\Models\DocumentTypes;

use App\Models\PhysicalInformations;

use App\Models\User;

use App\Models\Role;

use App\Models\ProcessApprovalFlow;

use App\Models\CustomerSites;

use App\Rules\OnePreferredBank;
use Carbon\Carbon;

use Filament\Forms;

use Filament\Forms\Components\TextInput;

use Filament\Forms\Components\Wizard;

use Filament\Forms\Form;

use Filament\Forms\Get;

use Filament\Forms\Set;

use Filament\Resources\Resource;

use Filament\Tables;

use Filament\Tables\Actions\Action;

use Filament\Tables\Actions\ActionGroup;

use Filament\Tables\Actions\EditAction;

use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletingScope;

use Illuminate\Support\Collection;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

use ArberMustafa\FilamentLocationPickrField\Forms\Components\LocationPickr;

use Filament\Forms\Components\DatePicker;

use Filament\Forms\Components\Grid;

use Filament\Forms\Components\Hidden;

use Filament\Forms\Components\Radio;

use Filament\Forms\Components\Select;

use Filament\Forms\Components\Textarea;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Blade;

use Illuminate\Support\HtmlString;

use Filament\Notifications\Notification;

use App\Enums\ApprovelStatus;

use App\Models\Financials;

use Traineratwot\FilamentOpenStreetMap\Forms\Components\MapInput;

use Filament\Tables\Actions\DeleteAction;

use App\Models\Setting;
class CustomerSitesResource extends Resource
{

    protected static ?string $model = CustomerSites::class;

    protected static ?string $navigationLabel = 'Customer Site';

    protected static ?string $pluralModelLabel = 'Customer Site';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Admin';





    public static function form(Form $form): Form
    {
        $isRequired = Setting::get('form_field_required') === '1';
        $isNameRequired = Setting::get('name_field_required') === '1';
        $isEmailRequired = Setting::get('email_field_required') === '1';
        $nearestLandmark = Setting::get('nearest_landmark') === '1';
        $postalCode = Setting::get('postal_code') === '1';
        $companyLandlineNumber = Setting::get('company_landline_number') === '1';
        $siteName = Setting::get('site_name') === '1';
        $locationName = Setting::get('location_name') === '1';
        // $locationType = Setting::get('location_type')==='1';
        $website = Setting::get('website') === '1';
        $groupCompany = Setting::get('group_company') === '1';
        $nameOfTheCompany = Setting::get('name_of_the_company') === '1';
        $nameOfContactPerson=Setting::get('name_of_the_contact_person') ==='1';
        $mobileNumber =Setting::get('mobile_number')==='1';
        $companyTypes=Setting::get('company_types_id')==='1';
        $yearsRelationship=Setting::get('year_relationship')==='1';
        $approxTurnOver = Setting::get('approx_turnover_for_last_year')==='1';
        $currency = Setting::get('currency') === '1';
        $bank = Setting::get('bank') === '1';
        $accountNumber = Setting::get('bank_account_number') === '1';
        $bankCode = Setting::get('bank_code') === '1';
        $iban = Setting::get('iban') === '1';
        $document =Setting::get('document') === '1';
        $country = Setting::get('country') === '1';
        $territory=Setting::get('territory_id') ==='1';
        $kenyaCities=Setting::get('kenya_cities_id')==='1';
        $bankDetails = Setting::get('bank_details') === '1';
        $swift = Setting::get('swift') === '1';
        $bankingFacilities = Setting::get('banking_facilities') === '1';
        $auditorName = Setting::get('auditor_name') === '1';
        $contactPersonName = Setting::get('contact_person_name') === '1';
        $financeEmailAddress = Setting::get('finance_email_address') === '1';
        $telephoneNumber = Setting::get('telephone_number') === '1';
        $financeMobileNumber = Setting::get('finance_mobile_number') === '1';
        $certificateOfIncorporation = Setting::get('certificate_of_incorporation') === '1';
        $certificateOfIncorporationIssueDate = Setting::get('certificate_of_incorporation_issue_date') === '1';
        $dateOfRegistration = Setting::get('date_of_registration') === '1';
        $businessPermitIssueExpiryDate = Setting::get('business_permit_issue_expiry_date') === '1';
        $businessPermitNumber = Setting::get('business_permit_number') === '1';
        $pinNumber = Setting::get('pin_number') === '1';
        $yearsInBusiness = Setting::get('years_in_business') === '1';
        $taxComplianceCertificate = Setting::get('tax_compliance_certificate') === '1';
        $excemptionCategory = Setting::get('excemption_category') === '1';
        $certificateOfIncorporationCopy = Setting::get('certificate_of_incorporation_copy') === '1';
        $pinCertificateCopy = Setting::get('pin_certificate_copy') === '1';
        $businessPermitCopy = Setting::get('business_permit_copy') === '1';
        $cr12Documents = Setting::get('cr12_documents') === '1';
        $passportCeo = Setting::get('passport_ceo') === '1';
        $passportPhotoCeo = Setting::get('passport_photo_ceo') === '1';
        $statement = Setting::get('statement') === '1';
        $documentTypeStatus = Setting::get('document_type_status') === '1';
        $description = Setting::get('description') === '1';
        $ownerContactName = Setting::get('owner_contact_name') === '1';
        $ownerContactEmailAddress = Setting::get('owner_contact_email_address') === '1';
        $ownerContactPhoneNumber = Setting::get('owner_contact_phone_number') === '1';
        $ceoContactName = Setting::get('ceo_contact_name') === '1';
        $ceoContactEmailAddress = Setting::get('ceo_contact_email_address') === '1';
        $ceoContactPhoneNumber = Setting::get('ceo_contact_phone_number') === '1';
        $cfoName = Setting::get('CFO/FM Name') === '1';
        $cfoContactEmailAddress = Setting::get('cfo_contact_email_address') === '1';
        $cfoContactPhoneNumber = Setting::get('cfo_contact_phone_number') === '1';
        $paymentContactName = Setting::get('payment_contact_name') === '1';
        $paymentContactEmailAddress = Setting::get('payment_contact_email_address') === '1';
        $paymentContactPhoneNumber = Setting::get('payment_contact_phone_number') === '1';
        $authorizedContactName = Setting::get('authorized_contact_name') === '1';
        $authorizedContactEmailAddress = Setting::get('authorized_contact_email_address') === '1';
        $authorizedContactPhoneNumber = Setting::get('authorized_contact_phone_number') === '1';
        return $form
            ->schema([
                //
                Forms\Components\Wizard::make([
                    Wizard\Step::make('physical_informations_id')
                        ->label('Physical Information')
                        ->schema([
                            Forms\Components\Section::make('Physical Information')->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required($isNameRequired)
                                    ->regex('/^[A-Z\s]+$/')
                                    ->label('Name')->afterStateUpdated(function ($state, $set) {
                                        $set('name', strtoupper($state));
                                    }),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required($isEmailRequired)
                                    // ->helperText('The email must end with .com' )
                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                                    ->label('Email'),
                                Forms\Components\TextInput::make('name_of_the_company')
                                    ->required($nameOfTheCompany)
                                    ->regex('/^[a-zA-Z0-9\s]+$/')
                                    ->label('Name of the Company')->afterStateUpdated(function ($state, $set) {
                                        $set('name_of_the_company', strtoupper($state));
                                       
                                    }),
                                Forms\Components\TextInput::make('group_company_of')
                                    ->required($groupCompany)
                                    ->regex('/^[a-zA-Z\s]+$/')
                                    ->label('Group Company'),
                                Forms\Components\TextInput::make('website')
                                    ->label('Website')
                                    ->required($website)
                                    ->rules(['regex:/^(www\.)?[a-zA-Z0-9-]+\.(com|org|in|net|us|es|fr|io|co|edu|gov|info)(?:\/[^\s]*)?$/'])
                                    ->rules(['regex:/^(www\.)[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/']),
                            ])->columns(2)
                        ]),

                        Wizard\Step::make('address_id')->Label('Address')
                        ->schema([
                            Forms\Components\Section::make('Address Details')
                    ->schema([
                        Forms\Components\Repeater::make('Address')
                        ->schema([
                            TextInput::make('location_name')
                            ->regex('/^[a-zA-Z\s]+$/')
                            ->label('Location Name')
                            ->required($locationName),
                        TextInput::make('site_name')
                            ->required($siteName)
                            ->label('Site Name')
                            ->regex('/^[a-zA-Z\s]+$/'),
                        Textarea::make('address_1')->label('Address 1')->maxLength(230)->required(),
                        Textarea::make('address_2')->label('Address 2')->maxLength(230),
                        Textarea::make('address_3')->label('Address 3')->maxLength(230),
                        Textarea::make('address_4')->label('Address 4')->maxLength(230),
                        Radio::make('location_type')->options([
                            'Head Office' => 'Head Office',
                            'branch' => 'Branch'
                        ])
                            ->default('Head Office')
                            ->inline()
                            ->inlineLabel(false),

                        Select::make('country_id')
                            ->relationship(name: 'country', titleAttribute: 'country_name')->required($country)
                            ->label('Country')
                            ->live()
                            ->default(static::getDefaultCountryId()),
                        Select::make('territory_id')
                            ->relationship(name: 'Territory', titleAttribute: 'territory')->required($territory)
                            ->label('Territory Name')
                            ->visible(fn (Get $get) => $get('country_id') == Country::where('country_name', 'Kenya')->first()->id ?? null),
                        Select::make('kenya_cities_id')
                            ->relationship(name: 'KenyaCities', titleAttribute: 'city')->required($kenyaCities)
                            ->label('Region')
                            ->visible(fn (Get $get) => $get('country_id') == Country::where('country_name', 'Kenya')->first()->id ?? null),
                        TextInput::make('companylandline_number')
                            ->label('Company landline number')
                            ->tel()
                            ->required($companyLandlineNumber)
                            ->minLength(10)
                            ->maxLength(15),
                        TextInput::make('nearest_landmark')
                            ->required($nearestLandmark)
                            ->label('Nearest Landmark')
                            ->regex('/^[a-zA-Z0-9\s]+$/'),
                        TextInput::make('postal_code')
                            ->required($postalCode)
                            ->label('Postal Code')
                            ->tel()
                            ->minLength(4)
                            ->regex('/^[a-zA-Z0-9\s]+$/'),
                        Hidden::make('payment_mode')
                            ->label('Payment Mode')
                            ->default('Cash'),
                        Grid::make(2)
                            ->schema([
                                MapInput::make('location')->label('Location')
                                    ->placeholder('Choose your location')
                                    ->coordinates(78.79934560848218, 22.38112547828412) // start coordinates
                                    ->rows(10) // height of map
                                    ->reactive()
                                    ->readOnly()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        $loc = explode(',', $state);
                                        $lat = $loc[0];
                                        $long = $loc[1];
                                        $set('longitude', $long);
                                        $set('latitude', $lat);
                                    })
                                    ->columnSpan(1), // Make the map take up one column
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('latitude')
                                            ->required()
                                            ->label('Latitude')
                                            ->readOnly(),
                                        TextInput::make('longitude')
                                            ->required()
                                            ->label('Longitude')
                                            ->readOnly(),
                                    ])->columnSpan(1) // Make the inputs take up one column
                            ])
                    ->columns(2),
                        ])->model(Address::class)
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->columns(2),
                        
                    ])
                    // ->model(Address::class)
                    // ->columns(2),
                        ]),
                    /*
----------------------------------------------------------------------------------------------------
 
                        Bank Informations
*/
                        Wizard\Step::make('business_references_id')
                        ->label('Business Reference')
                       
                        ->schema([
                            Forms\Components\Section::make('Business References')->schema([
                                Forms\components\Repeater::make('Business References')->label('Business References') ->schema([
                                Forms\Components\TextInput::make('name_of_company')
                                    ->label('Company Name')
                                    ->required($nameOfTheCompany)
                                    ->regex('/^[a-zA-Z0-9\s]+$/'),
                                Forms\Components\TextInput::make('name_of_the_contact_person')
                                    ->label('Contact Person')
                                    ->required($nameOfContactPerson)
                                    ->regex('/^[a-zA-Z\s]+$/'),
                                Forms\Components\TextInput::make('email_address')
                                    ->label('Email')
                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                                    ->email($isEmailRequired),
                                Forms\Components\TextInput::make('telephone_number')
                                    ->label('Telephone Number')
                                    ->required($telephoneNumber)
                                    ->tel()->minLength(8),
                                Forms\Components\TextInput::make('mobile_number')
                                    ->label('Mobile Number')
                                    ->required($mobileNumber)
                                    ->tel()->minLength(8),
                                Forms\Components\Select::make('company_types_id')
                                    ->options(fn (Get $get): Collection => CompanyTypes::query()
                                    ->where('legal_information_restriction', '1')
                                    ->pluck('company_type_name', 'id'))
                                    ->label('Company Types')
                                    ->required(),
                                TextInput::make('year_relationship')
                                    ->label('Years in Relationship')
                                    ->required($yearsRelationship),
                                ])->columns(2)
                            ])->columnSpanFull(),
                        ]),
 
                   
// ----------------------------------------------------------------------------------------------------
 
 
                    Wizard\Step::make('financials_id')
                        ->label('Financials')
                        ->schema([
                            Forms\Components\Section::make('Financials')->schema([
                                Forms\Components\TextInput::make('approx_turnover_for_last_year')
                                    ->required($approxTurnOver)
                                    ->regex('/^[0-9\s]+$/')
                                    ->label('Approx Turn Over For Last Year (Millions in kenya shilling)'),
                                Forms\Components\TextInput::make('name_of_auditor')
                                    ->required($auditorName)
                                    ->label('Auditor Name')
                                    ->regex('/^[a-zA-Z\s]+$/'),
                                Forms\Components\TextInput::make('finance_contact_person')
                                    ->required($contactPersonName)
                                    ->label('Contact Person Name')
                                    ->regex('/^[a-zA-Z\s]+$/'),
                                Forms\Components\TextInput::make('finance_email_address')
                                    ->required($financeEmailAddress)
                                    ->label('Email')
                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                                    ->email(),
                                Forms\Components\TextInput::make('finance_telephone_number')
                                    ->label('Telephone Number')
                                    ->tel()
                                    ->required($telephoneNumber)
                                    ->minLength(8)
                                    ->rule('regex:/^\S*$/', 'The telephone number cannot contain spaces.'),
                                Forms\Components\TextInput::make('finance_mobile_number')
                                    ->required($financeMobileNumber)
                                    ->label('Mobile Number')
                                    ->tel()
                                    ->minLength(8)
                                    ->rule('regex:/^\S*$/', 'The telephone number cannot contain spaces.'),
                            ])->columns(2)
                        ]),
                   
// ----------------------------------------------------------------------------------------------------
 
                        // Key Management
// */
 
 
                                    Wizard\Step::make('key_managements_id')
                                    ->label('Key Management')
                                    ->schema([
                                        Forms\Components\Section::make('Key Management')->schema([
                                            Forms\Components\Section::make('Name of The Owner')->schema([
                                                Forms\Components\TextInput::make('owner_contact_name')
                                                    ->label('Contact Name')
                                                    ->required($ownerContactName)
                                                    ->regex('/^[a-zA-Z\s]+$/'),
                                                Forms\Components\TextInput::make('owner_contact_email_address')
                                                    ->label('Contact Email Address')
                                                    ->required($ownerContactEmailAddress)
                                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                                                    ->email(),
                                                Forms\Components\TextInput::make('owner_contact_phone_number')
                                                    ->label('Contact Phone Number')
                                                    ->required($ownerContactPhoneNumber)
                                                    ->tel()->minLength(8),
                                            
                                            ])->columns(3),
                                            Forms\Components\Section::make('Name of CEO/GM')->schema([
                                                Forms\Components\TextInput::make('ceo_contact_name')->label('CEO/GM Name ')
                                                    ->required($ceoContactName)
                                                    ->regex('/^[a-zA-Z\s]+$/'),
                                                Forms\Components\TextInput::make('ceo_contact_email_address')
                                                    ->label('Contact Email Address')
                                                    ->email()
                                                    ->required($ceoContactEmailAddress)
                                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/']),
                                        Forms\Components\TextInput::make('ceo_contact_phone_number')
                                                    ->label('Contact Phone Number')
                                                    ->required( $ceoContactPhoneNumber)
                                                    ->tel()->minLength(8),
                                                
                                            ])->columns(3),
                                            Forms\Components\Section::make('Name of CFO/FM')->schema([
                                                Forms\Components\TextInput::make('cfo_contact_name')
                                                    ->label('CFO/FM Name')
                                                    ->required($cfoName)
                                                    ->regex('/^[a-zA-Z\s]+$/'),
                                                Forms\Components\TextInput::make('cfo_contact_email_address')
                                                    ->label('Contact Email Address')
                                                    ->email()
                                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                                                    ->required($cfoContactEmailAddress),
                                                Forms\Components\TextInput::make('cfo_contact_phone_number')
                                                    ->label('Contact Phone Number')
                                                    ->required($cfoContactPhoneNumber)
                                                    ->tel()->minLength(8),
                                                
                                            ])->columns(3),
                                            Forms\Components\Section::make('Name of Person to follow up for Payment')->schema([
                                                Forms\Components\TextInput::make('payment_contact_name')
                                                    ->label('Contact Name')
                                                    ->required($paymentContactName)->regex('/^[a-zA-Z\s]+$/'),
                                                Forms\Components\TextInput::make('payment_contact_email_address')
                                                    ->label('Contact Email Address')
                                                    ->email()
                                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                                                    ->required($paymentContactEmailAddress),
                                                Forms\Components\TextInput::make('payment_contact_phone_number')
                                                    ->label('Contact Phone Number')
                                                    ->tel()->minLength(8)
                                                    ->required($paymentContactPhoneNumber),
                                                
                                            ])->columns(3),
                                            Forms\Components\Section::make('Name of Person Authorized to place PO')->schema([
                                                Forms\Components\TextInput::make('authorized_contact_name')
                                                    ->label('Contact Name ')
                                                    ->required($authorizedContactName)
                                                    ->regex('/^[a-zA-Z\s]+$/'),
                                                Forms\Components\TextInput::make('authorized_contact_email_address')
                                                    ->label('Contact Email Address')
                                                    ->email()
                                                    ->required($authorizedContactEmailAddress)
                                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/']),                                        
                                                Forms\Components\TextInput::make('authorized_contact_phone_number')
                                                    ->label('Contact Phone Number')
                                                    ->tel()
                                                    ->minLength(8)
                                                    ->required($authorizedContactPhoneNumber),
                                                
                                            ])->columns(3),
                                            Forms\Components\TextArea::make('any_other_remarks')->label('Any Other Remarks')->columnSpan('full'),
                                        ])

                                    ]),
                    /*
----------------------------------------------------------------------------------------------------
 
                        Legal Information
*/
 
 
                                            Wizard\Step::make('legal_informations_id')
                                            ->label('Legal Information')
                                            ->schema([
                                                Forms\Components\Section::make('Legal Information')->schema([
                                                    Forms\Components\TextInput::make('certificate_of_incorporation')
                                                        ->required($certificateOfIncorporation)
                                                        ->regex('/^[a-zA-Z0-9\s!@#\$%\^&\*\(\)_\-\+=\{\}\[\];"<>,]+$/')
                                                        ->label('Incorporation Certificate'),
                                                        DatePicker::make('certificate_of_incorporation_issue_date')
                                                        
                                                         ->displayFormat('d/m/Y')
                                                        ->label('Date of Registration')
                                                        ->required($certificateOfIncorporationIssueDate)
                                                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                                            // Calculate years in business when the registration date is updated
                                                            $issueDate = Carbon::parse($state);
                                                            $currentDate = Carbon::now();
                                                            $yearsInBusiness = $issueDate->diffInYears($currentDate);
                                                            $set('years_in_business', $yearsInBusiness);
                                                        })
                                                        ->live(),
                                                    
                                                    DatePicker::make('business_permit_issue_expiry_date')
                                                        ->label('Business Permit Expiry Date')
                                                        ->required($businessPermitIssueExpiryDate)
                                                        ->minDate(function (Get $get) {
                                                            // Ensure the expiry date is after the incorporation issue date
                                                            return $get('certificate_of_incorporation_issue_date');
                                                        })
                                                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                                            $certificateDate = $get('certificate_of_incorporation_issue_date');
                                                            if ($certificateDate && Carbon::parse($state)->lt(Carbon::parse($certificateDate))) {
                                                                // If the selected expiry date is before the certificate issue date, reset it
                                                                $set('business_permit_issue_expiry_date', null);
                                                               
                                                            }
                                                        }),
                                                        // ->native(false),
                                                    Forms\Components\TextInput::make('business_permit_number')
                                                        ->required($businessPermitNumber)
                                                        ->regex('/^[A-Za-z0-9\s]+$/')
                                                        ->minLength(5)
                                                        ->label('Business Permit Number'),
                                                    Forms\Components\TextInput::make('pin_number')
                                                        ->required($pinNumber)
                                                        ->regex('/^[a-zA-Z0-9\s]+$/')
                                                        ->minLength(6)
                                                        ->maxLength(10)
                                                        ->label('Pin Certificate Number'),
                                                    Forms\Components\TextInput::make('years_in_business')
                                                        ->readOnly()
                                                        ->extraInputAttributes([
                                                            'style' => 'background-color: #f0f0f0; color: #333;',
                                                        ])
                                                        ->required($yearsInBusiness)
                                                        ->label('Years in Business'),
                                                    Forms\Components\FileUpload::make('certificate_of_incorporation_copy')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()
                                                        ->required($certificateOfIncorporationCopy)
                                                        ->label('Certificate of Incorporation Copy'),
                                                    Forms\Components\FileUpload::make('pin_certificate_copy')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()
                                                        ->label('Pin Certificate Copy')
                                                        ->required($pinCertificateCopy),
                                                    Forms\Components\FileUpload::make('business_permit_copy')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()->label('Business Permit Copy')
                                                        ->required($businessPermitCopy),
                                                    Forms\Components\FileUpload::make('cr12_documents')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()->label('CR12 Document')
                                                        ->required($cr12Documents),
                                                    Forms\Components\FileUpload::make('passport_ceo')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()->label('Passport/National ID of Director/CEO')
                                                        ->required($passportCeo),
                                                    Forms\Components\FileUpload::make('passport_photo_ceo')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()->label('Passport size Photo of Director/ CEO ')
                                                        ->required($passportPhotoCeo),
                                                    Forms\Components\FileUpload::make('statement')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()->label('Statement')
                                                        ->required($statement),
                                                        
                                                ])
                                                    ->columns(2)
                                            ]),
                    /*
----------------------------------------------------------------------------------------------------
 
                        Other Documents
*/
 
                    Wizard\Step::make('other_documents_id')
                        ->label('Other Documents')
                        ->schema([
                            Forms\Components\Section::make('Other Documents')->schema([
                                Forms\components\Repeater::make('Other Documents')->label('Other Documents')->schema([
                                    Forms\Components\Select::make('document_types_id')->label('Document Name')
                                        ->options(fn (Get $get): Collection => DocumentTypes::query()
                                            ->where('document_type_status', '1')
                                            ->pluck('document_type_name', 'id'))->required($documentTypeStatus),
                                    Forms\Components\FileUpload::make('document')
                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                        ->maxSize(1000)
                                        ->preserveFilenames()
                                        ->label('Document')->required($document),
                                    Forms\Components\Textarea::make('description')
                                        ->label('Description')
                                        ->required($description),
                                        
                                ])->deletable(false)
                                    ->reorderable(false),
                                Forms\Components\Checkbox::make('terms')->label('Terms')
                                    ->required()
                                    ->helperText(new \Illuminate\Support\HtmlString(
                                        '<div style="text-align: justify; font-family: Arial, sans-serif; margin: 20px;">
                                           <b> By signing this Account Opening form I agree and authorize Pwani Oil Products Limited to:</b><br><br>
                                            <ol>
                                                <li>1. To Make any necessary inquiries in connection with this application.</li><br>
                                                <li>2. To Procure my personal information and credit history, as well as that of my directors/guarantors, from licensed Credit Reference Bureaus (CRBs), as applicable.</li><br>
                                                <li>To Supply and share my personal and credit information with licensed Credit Reference Bureaus.
                                                <b>I release Pwani Oil Products Limited, along with its employees and/or agents, from any claims, actions, and legal proceedings that they may incur in connection with submitting, receiving, using, and/or sharing my credit information.</b><br><br>
                                            I confirm that I have read and understood the standard trading terms and conditions (as amended from time to time) and agree to be bound by them.
                                        </div>'
                                    ))
                                    ->rules(['accepted']),
                            ])->columnspan(1)
                        ]),
                ])->columnSpanFull()
                    // ->skippable()
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                <x-filament::button
                    type="submit"
                    size="sm"
                >
                    Submit
                </x-filament::button>
            BLADE))),
                // Add the custom HTML content view here
                Forms\Components\View::make('components.footer')->columnSpanFull()
 
            ]);
    }

    public static function addressForm(Form $form): Form
    {
        $nearestLandmark = Setting::get('nearest_landmark') === '1';
        $postalCode = Setting::get('postal_code') === '1';
        $companyLandlineNumber = Setting::get('company_landline_number') === '1';
        $siteName = Setting::get('site_name') === '1';
        $locationName = Setting::get('location_name') === '1';
        $country = Setting::get('country') === '1';
        $territory=Setting::get('territory_id') ==='1';
        $kenyaCities=Setting::get('kenya_cities_id')==='1';
        $address1=Setting::get('address_1')==='1';
        $address2=Setting::get('address_2')==='1';
        $address3=Setting::get('address_3')==='1';
        $address4=Setting::get('address_4')==='1';
        $location=Setting::get('location')==='1';
        $latitude=Setting::get('latitude')==='1';
        $longitude=Setting::get('longitude')==='1';
        return $form
            ->schema([
                //
                Forms\Components\Wizard::make([
                    Wizard\Step::make('address_id')->Label('Address')
                        ->schema([
                            Forms\Components\Section::make('Address Details')
                    ->schema([
                        Forms\Components\Repeater::make('Address')
                        ->schema([
                            TextInput::make('location_name')
                            ->regex('/^[a-zA-Z\s]+$/')
                            ->label('Location Name')
                            ->required($locationName),
                        TextInput::make('site_name')
                            ->required($siteName)
                            ->label('Site Name')
                            ->regex('/^[a-zA-Z\s]+$/'),
                        Textarea::make('address_1')->label('Address 1')->maxLength(230)->required($address1),
                        Textarea::make('address_2')->label('Address 2')->maxLength(230)->required($address2),
                        Textarea::make('address_3')->label('Address 3')->maxLength(230)->required($address3),
                        Textarea::make('address_4')->label('Address 4')->maxLength(230)->required($address4),
                        Radio::make('location_type')->options([
                            'Head Office' => 'Head Office',
                            'branch' => 'Branch'
                        ])
                            ->default('Head Office')
                            ->inline()
                            ->inlineLabel(false),

                        Select::make('country_id')
                            ->relationship(name: 'country', titleAttribute: 'country_name')->required($country)
                            ->label('Country')
                            ->live()
                            ->default(static::getDefaultCountryId()),
                        Select::make('territory_id')
                            ->relationship(name: 'Territory', titleAttribute: 'territory')->required($territory)
                            ->label('Territory Name')
                            ->visible(fn (Get $get) => $get('country_id') == Country::where('country_name', 'Kenya')->first()->id ?? null),
                        Select::make('kenya_cities_id')
                            ->relationship(name: 'KenyaCities', titleAttribute: 'city')->required($kenyaCities)
                            ->label('Region')
                            ->visible(fn (Get $get) => $get('country_id') == Country::where('country_name', 'Kenya')->first()->id ?? null),
                        TextInput::make('companylandline_number')
                            ->label('Company landline number')
                            ->tel()
                            ->required($companyLandlineNumber)
                            ->minLength(10)
                            ->maxLength(15),
                        TextInput::make('nearest_landmark')
                            ->required($nearestLandmark)
                            ->label('Nearest Landmark')
                            ->regex('/^[a-zA-Z0-9\s]+$/'),
                        TextInput::make('postal_code')
                            ->required($postalCode)
                            ->label('Postal Code')
                            ->tel()
                            ->minLength(4)
                            ->regex('/^[a-zA-Z0-9\s]+$/'),
                        Hidden::make('payment_mode')
                            ->label('Payment Mode')
                            ->default('Cash'),
                        Grid::make(2)
                            ->schema([
                                MapInput::make('location')->label('Location')
                                    ->placeholder('Choose your location')
                                    ->coordinates(78.79934560848218, 22.38112547828412) // start coordinates
                                    ->rows(10) // height of map
                                    ->reactive()
                                    ->required($location)
                                    ->readOnly()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        $loc = explode(',', $state);
                                        $lat = $loc[0];
                                        $long = $loc[1];
                                        $set('longitude', $long);
                                        $set('latitude', $lat);
                                    })
                                    ->columnSpan(1), // Make the map take up one column
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('latitude')
                                            ->required($latitude)
                                            ->label('Latitude')
                                            ->readOnly(),
                                        TextInput::make('longitude')
                                            ->required($longitude)
                                            ->label('Longitude')
                                            ->readOnly(),
                                    ])->columnSpan(1) // Make the inputs take up one column
                            ])
                    ->columns(2),
                        ])->model(Address::class)
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->columns(2),
                        
                    ])
                    // ->model(Address::class)
                    // ->columns(2),
                        ]),
                        ])->columnSpanFull()
                        // ->skippable()
                        ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm"
                    >
                        Submit
                    </x-filament::button>
                BLADE))),
                    // Add the custom HTML content view here
                    Forms\Components\View::make('components.footer')->columnSpanFull()
        
                ]);

    }


    public static function table(Table $table): Table
    {

        return $table

            ->columns([

                //

                Tables\Columns\TextColumn::make('physicalInformation.id')

                    ->label('#'),

                    Tables\Columns\TextColumn::make('customer.customer_number')
                    
                    ->label('Customer Number'), 
                    
                Tables\Columns\TextColumn::make('physicalInformation.name')

                    ->label('Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('physicalInformation.email')

                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('physicalInformation.name_of_the_company')

                    ->label('Company Name')
                    ->searchable(),



                Tables\Columns\TextColumn::make('keyManagements.owner_phone_number')

                    ->label('Mobile')

                    ->getStateUsing(function (CustomerSites $record) {

                        $finance = Financials::find($record->financials_id);

                        return $finance ? $finance->finance_mobile_number : '';
                    }),


                    Tables\Columns\TextColumn::make('update_type')
                    ->getStateUsing(function (CustomerSites $record) {
    
                        if($record->update_type == 1){
                            return 'Site Updated';
                        }
                        else if($record->update_type == 2){
                            return'Bank Updated';
                        }
                        else{
                            return '';
                        }
                    })
                    ->wrap()
                        ->label('Update Type'),

                Tables\Columns\TextColumn::make('status')

                    ->wrap()

                    ->getStateUsing(function (CustomerSites $record) {


                        $status = '';
                        $curStatus = ApprovalStatus::select('status', 'user_id')->where('customer_sites_id', $record->id)->orderBy('id', 'desc')->first();
                        if (
                            $record->status == ApplicationStatus::SUBMITTED &&
                            ($curStatus === null || $curStatus->status == ApprovelStatus::REJECTED)
                        ) {

                            return 'Application Submitted. Pending for Verification';
                        } else if ($curStatus->status == ApprovelStatus::PROCESSING) {
                            $siteStatus = ApprovalStatus::select('status', 'user_id')->where('customer_sites_id', $record->id)->orderBy('id', 'desc')->limit(2)->get()->toArray();
                            $currentStatus = $siteStatus[0];
                            $previousStatus = $siteStatus[1];
                            return $status = strtoupper($previousStatus['status']) . ' By '  . User::find($previousStatus['user_id'])->name . '. Pending for Verification from ' . User::find($currentStatus['user_id'])->name;
                        } else if ($record->status == ApplicationStatus::APPROVED && $curStatus->status == ApprovelStatus::APPROVED) {
                            return $status = strtoupper($curStatus->status->value) . ' By ' . User::find($curStatus->user_id)->name;
                        } else if ($record->status == ApplicationStatus::REJECTED && $curStatus->status == ApprovelStatus::REJECTED) {
                            return $status = strtoupper($curStatus->status->value) . ' By ' . User::find($curStatus->user_id)->name;
                        }
                    }),

            ])

            ->filters([

                //

            ])

            ->actions([

                ActionGroup::make([

                    Tables\Actions\ViewAction::make('view')

                        // ->visible(function (Model $record) {

                        //     /** @var App\Models\User $user */

                        //     $user = auth()->user();

                        //     return $user->canView();
                        // })
                        ,

                    Tables\Actions\EditAction::make('edit')

                        ->visible(function (Model $record) {

                            /** @var App\Models\User $user */

                            $user = auth()->user();

                            $flow = (new ProcessApprovalFlow)->where('role_id', $user->roles->first()->id)->first();

                            if ($user->canEdit() && $flow?->order == $record->approval_flow && $record->status == ApplicationStatus::SUBMITTED  ) {

                                return true;
                            }

                            return false;
                        }),
                        DeleteAction::make()
                        ->visible(function ()
                        {
                             /** @var App\Models\User $user */
                             $user = auth()->user();
                             if($user->hasRole(['Admin']) ){
                                return true;
                            }
                            return false;
                        }),

                    ApproveAction::make()
                        ->visible(function (Model $record) {
                            /** @var App\Models\User $user */
                            $user = auth()->user();
                            $flow = (new ProcessApprovalFlow)->where('role_id', $user->roles->first()->id)->first();
                            if ($user->canApprove() && $flow?->order == $record->approval_flow && $record->status == ApplicationStatus::SUBMITTED) {
                                return true;
                            }
                            return false;
                        }),
                    RejectAction::make()
                        ->visible(function (Model $record) {
                            /** @var App\Models\User $user */
                            $user = auth()->user();
                            $flow = (new ProcessApprovalFlow)->where('role_id', $user->roles->first()->id)->first();
                            if ($user->canReject() && $flow?->order == $record->approval_flow && $record->status == ApplicationStatus::SUBMITTED) {
                                return true;
                            }
                            return false;
                        }),
                ])

                    ->label('Actions')

                    ->icon('heroicon-m-ellipsis-vertical')

                    ->color('info')

                    ->button(),

            ])

            ->bulkActions([

                Tables\Actions\BulkActionGroup::make([

                    Tables\Actions\DeleteBulkAction::make(),

                ]),

            ]);
    }



    public static function getRelations(): array
    {

        return [

            //

        ];
    }



    public static function getPages(): array
    {

        return [

            'index' => Pages\ListCustomerSites::route('/'),

            'create' => Pages\CreateCustomerSites::route('/create'),

            'view' => Pages\ViewCustomerSites::route('/{record}'),

            'edit' => Pages\EditCustomerSites::route('/{record}/edit'),

        ];
    }



    public static function getEloquentQuery(): Builder
    {

        $user = Auth::user();

        $flow = (new ProcessApprovalFlow)->where('role_id', $user->roles->first()->id)->first();



        return parent::getEloquentQuery()

            ->where('status', '!=', ApplicationStatus::INCOMPLETE);
        // where('status', ApplicationStatus::SUBMITTED)

        // ->orWhere('status', ApplicationStatus::APPROVED)

        // ->orWhere('status', ApplicationStatus::REJECTED);

        // ->where('approval_flow', $flow?->order ?? 0);

    }

    protected static function getDefaultCountryId()
    {

        $defaultCountry = Country::where('country_name', 'Kenya')->first();

        return $defaultCountry ? $defaultCountry->id : null;
    }
}
