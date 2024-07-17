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

class CustomerSitesResource extends Resource
{

    protected static ?string $model = CustomerSites::class;

    protected static ?string $navigationLabel = 'Customer Site';

    protected static ?string $pluralModelLabel = 'Customer Site';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Admin';





    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Wizard::make([
                    Wizard\Step::make('physical_informations_id')
                        ->label('Physical Information')
                        ->schema([
                            Forms\Components\Section::make('Physical Information')->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->regex('/^[A-Z\s]+$/')
                                    ->label('Name')->afterStateUpdated(function ($state, $set) {
                                        $set('name', strtoupper($state));
                                    }),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    // ->helperText('The email must end with .com' )
                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                                    ->label('Email'),
                                Forms\Components\TextInput::make('name_of_the_company')
                                    ->required()
                                    ->regex('/^[a-zA-Z0-9\s]+$/')
                                    ->label('Name of the Company')->afterStateUpdated(function ($state, $set) {
                                        $set('name_of_the_company', strtoupper($state));
                                       
                                    }),
                                Forms\Components\TextInput::make('group_company_of')
                                    ->required()
                                    ->regex('/^[a-zA-Z\s]+$/')
                                    ->label('Group Company'),
                                Forms\Components\TextInput::make('website')
                                    ->label('Website')
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
                            ->required(),
                        TextInput::make('site_name')
                            ->required()
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
                            ->relationship(name: 'country', titleAttribute: 'country_name')->required()
                            ->label('Country')
                            ->live()
                            ->default(static::getDefaultCountryId()),
                        Select::make('territory_id')
                            ->relationship(name: 'Territory', titleAttribute: 'territory')->required()
                            ->label('Territory Name')
                            ->visible(fn (Get $get) => $get('country_id') == Country::where('country_name', 'Kenya')->first()->id ?? null),
                        Select::make('kenya_cities_id')
                            ->relationship(name: 'KenyaCities', titleAttribute: 'city')->required()
                            ->label('Region')
                            ->visible(fn (Get $get) => $get('country_id') == Country::where('country_name', 'Kenya')->first()->id ?? null),
                        TextInput::make('companylandline_number')
                            ->label('Company landline number')
                            ->tel()
                            ->minLength(10)
                            ->maxLength(15),
                        TextInput::make('nearest_landmark')
                            ->required()
                            ->label('Nearest Landmark')
                            ->regex('/^[a-zA-Z0-9\s]+$/'),
                        TextInput::make('postal_code')
                            ->required()
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
                                    ->required()
                                    ->regex('/^[a-zA-Z0-9\s]+$/'),
                                Forms\Components\TextInput::make('name_of_the_contact_person')->label('Contact Person')->required()->regex('/^[a-zA-Z\s]+$/'),
                                Forms\Components\TextInput::make('email_address')
                                    ->label('Email')
                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                                    ->email(),
                                Forms\Components\TextInput::make('telephone_number')->label('Telephone Number')->required()->tel()->minLength(8),
                                Forms\Components\TextInput::make('mobile_number')->label('Mobile Number')->required()->tel()->minLength(8),
                                Forms\Components\Select::make('company_types_id')
                                    ->options(fn (Get $get): Collection => CompanyTypes::query()
                                        ->where('legal_information_restriction', '1')
                                        ->pluck('company_type_name', 'id'))
                                        ->label('Company Types')
                                    ->required(),
                                TextInput::make('year_relationship')->label('Years in Relationship')->required(),
                                ])->columns(2)
                            ])->columnSpanFull(),
                        ]),
 
                   
// ----------------------------------------------------------------------------------------------------
 
 
                    Wizard\Step::make('financials_id')
                        ->label('Financials')
                        ->schema([
                            Forms\Components\Section::make('Financials')->schema([
                                Forms\Components\TextInput::make('approx_turnover_for_last_year')
                                    ->required()
                                    ->regex('/^[0-9\s]+$/')
                                    ->label('Approx Turn Over For Last Year (Millions in kenya shilling)'),
                                Forms\Components\TextInput::make('name_of_auditor')->required()->label('Auditor Name')->regex('/^[a-zA-Z\s]+$/'),
                                Forms\Components\TextInput::make('finance_contact_person')->required()->label('Contact Person Name')->regex('/^[a-zA-Z\s]+$/'),
                                Forms\Components\TextInput::make('finance_email_address')
                                    ->required()
                                    ->label('Email')
                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                                    ->email(),
                                Forms\Components\TextInput::make('finance_telephone_number')
                                    ->label('Telephone Number')
                                    ->tel()
                                    ->minLength(8)
                                    ->rule('regex:/^\S*$/', 'The telephone number cannot contain spaces.'),
                                Forms\Components\TextInput::make('finance_mobile_number')
                                    ->required()
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
                                                Forms\Components\TextInput::make('owner_contact_name')->label('Contact Name')->required()->regex('/^[a-zA-Z\s]+$/'),
                                                Forms\Components\TextInput::make('owner_contact_email_address')
                                                    ->label('Contact Email Address')
                                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                                                    ->email(),
                                                Forms\Components\TextInput::make('owner_contact_phone_number')->label('Contact Phone Number')->tel()->minLength(8),
                                            
                                            ])->columns(3),
                                            Forms\Components\Section::make('Name of CEO/GM')->schema([
                                                Forms\Components\TextInput::make('ceo_contact_name')->label('CEO/GM Name ')->required()->regex('/^[a-zA-Z\s]+$/'),
                                                Forms\Components\TextInput::make('ceo_contact_email_address')
                                                    ->label('Contact Email Address')
                                                    ->email()
                                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/']),
                                        Forms\Components\TextInput::make('ceo_contact_phone_number')->label('Contact Phone Number')->tel()->minLength(8),
                                                
                                            ])->columns(3),
                                            Forms\Components\Section::make('Name of CFO/FM')->schema([
                                                Forms\Components\TextInput::make('cfo_contact_name')->label('CFO/FM Name')->required()->regex('/^[a-zA-Z\s]+$/'),
                                                Forms\Components\TextInput::make('cfo_contact_email_address')
                                                    ->label('Contact Email Address')
                                                    ->email()
                                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                                                    ->required(),
                                                Forms\Components\TextInput::make('cfo_contact_phone_number')->label('Contact Phone Number')->tel()->minLength(8),
                                                
                                            ])->columns(3),
                                            Forms\Components\Section::make('Name of Person to follow up for Payment')->schema([
                                                Forms\Components\TextInput::make('payment_contact_name')->label('Contact Name')->required()->regex('/^[a-zA-Z\s]+$/'),
                                                Forms\Components\TextInput::make('payment_contact_email_address')
                                                    ->label('Contact Email Address')
                                                    ->email()
                                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                                                    ,
                                                Forms\Components\TextInput::make('payment_contact_phone_number')->label('Contact Phone Number')->tel()->minLength(8)->required(),
                                                
                                            ])->columns(3),
                                            Forms\Components\Section::make('Name of Person Authorized to place PO')->schema([
                                                Forms\Components\TextInput::make('authorized_contact_name')->label('Contact Name ')->required()->regex('/^[a-zA-Z\s]+$/'),
                                                Forms\Components\TextInput::make('authorized_contact_email_address')
                                                    ->label('Contact Email Address')
                                                    ->email()
                                                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/']),                                        
                                                Forms\Components\TextInput::make('authorized_contact_phone_number')->label('Contact Phone Number')->tel()->minLength(8)->required(),
                                                
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
                                                        ->required()
                                                        ->regex('/^[a-zA-Z0-9\s]+$/')
                                                        ->label('Incorporation Certificate'),
                                                        DatePicker::make('certificate_of_incorporation_issue_date')
                                                        
                                                         ->displayFormat('d/m/Y')
                                                        ->label('Date of Registration')
                                                        ->required()
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
                                                        ->required()
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
                                                        ->required()
                                                        ->regex('/^[A-Za-z0-9\s]+$/')
                                                        ->minLength(5)
                                                        ->label('Business Permit Number'),
                                                    Forms\Components\TextInput::make('pin_number')
                                                        ->required()
                                                        ->regex('/^[a-zA-Z0-9\s]+$/')
                                                        ->minLength(6)
                                                        ->maxLength(10)
                                                        ->label('Pin Certificate Number'),
                                                    Forms\Components\TextInput::make('years_in_business')
                                                        ->readOnly()
                                                        ->extraInputAttributes([
                                                            'style' => 'background-color: #f0f0f0; color: #333;',
                                                        ])
                                                        ->label('Years in Business'),
                                                    Forms\Components\FileUpload::make('certificate_of_incorporation_copy')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()->required()->label('Certificate of Incorporation Copy'),
                                                    Forms\Components\FileUpload::make('pin_certificate_copy')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()->label('Pin Certificate Copy')->required(),
                                                    Forms\Components\FileUpload::make('business_permit_copy')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()->label('Business Permit Copy')->required(),
                                                    Forms\Components\FileUpload::make('cr12_documents')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()->label('CR12 Document')->required(),
                                                    Forms\Components\FileUpload::make('passport_ceo')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()->label('Passport/National ID of Director/CEO')->required(),
                                                    Forms\Components\FileUpload::make('passport_photo_ceo')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()->label('Passport size Photo of Director/ CEO ')->required(),
                                                    Forms\Components\FileUpload::make('statement')
                                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                                        ->maxSize(1000)
                                                        ->preserveFilenames()->label('Statement')->required(),
                                                        
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
                                            ->pluck('document_type_name', 'id'))->required(),
                                    Forms\Components\FileUpload::make('document')
                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv', 'application/msword'])
                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv, DOC Maximum size -> 1MB")
                                        ->maxSize(1000)
                                        ->preserveFilenames()
                                        ->label('Document')->required(),
                                    Forms\Components\Textarea::make('description')
                                        ->label('Description'),
                                        
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
                            ->required(),
                        TextInput::make('site_name')
                            ->required()
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
                            ->relationship(name: 'country', titleAttribute: 'country_name')->required()
                            ->label('Country')
                            ->live()
                            ->default(static::getDefaultCountryId()),
                        Select::make('territory_id')
                            ->relationship(name: 'Territory', titleAttribute: 'territory')->required()
                            ->label('Territory Name')
                            ->visible(fn (Get $get) => $get('country_id') == Country::where('country_name', 'Kenya')->first()->id ?? null),
                        Select::make('kenya_cities_id')
                            ->relationship(name: 'KenyaCities', titleAttribute: 'city')->required()
                            ->label('Region')
                            ->visible(fn (Get $get) => $get('country_id') == Country::where('country_name', 'Kenya')->first()->id ?? null),
                        TextInput::make('companylandline_number')
                            ->label('Company landline number')
                            ->tel()
                            ->minLength(10)
                            ->maxLength(15),
                        TextInput::make('nearest_landmark')
                            ->required()
                            ->label('Nearest Landmark')
                            ->regex('/^[a-zA-Z0-9\s]+$/'),
                        TextInput::make('postal_code')
                            ->required()
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
