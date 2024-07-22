<?php

namespace App\Filament\CustomerResources\CustomerSitesResource\Pages;

use App\Enums\ApplicationStatus;
use App\Filament\Actions\ReSubmit;
use App\Filament\Actions\Submit;
use App\Filament\CustomerResources\CustomerSitesResource;
use App\Models\BankInformations;
use App\Models\Address;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\BusinessReferences;
use App\Models\CompanyTypes;
use App\Models\Country;
use App\Models\Currency;
use App\Models\DocumentTypes;
use App\Models\Financials;
use App\Models\KeyManagements;
use App\Models\LegalInformations;
use App\Models\OtherDocuments;
use App\Models\PhysicalInformations;
use App\Rules\OnePreferredBank;
use Exception;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\DateColumn;
use Filament\Tables\Columns\Column;
use Carbon\Carbon;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\Actions as ComponentsActions;
use Filament\Infolists\Components\Actions\Action;
use Illuminate\Support\Collection;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\ProcessApprovalFlow;
use App\Enums\ApprovelStatus;
use App\Models\User;
use App\Models\ApprovalStatus;
use App\Models\Customer;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;
use Traineratwot\FilamentOpenStreetMap\Forms\Components\MapInput;



class ViewCustomerSites extends ViewRecord
{
    protected static string $resource = CustomerSitesResource::class;
    protected static ?string $navigationLabel = 'Customer Site';
    protected function getHeaderActions(): array
    {
        return [
            Submit::make(),
            ReSubmit::make(),
            EditAction::make()
            ->visible(function (Model $record) {
                if ($record->status->value == 'rejected' || $record->status->value == 'incompleted') {
                    return true;
                }
                return false;
            }),
        ];
    }

    protected function getViewData(): array
    {
        $additionalData = $this->getRecord();
        $physicalRecord = PhysicalInformations::find($additionalData->physical_informations_id);
        $bank = BankInformations::query()->where('customer_id', auth()->user()->id)->get()->toArray();
        $business = BusinessReferences::query()->where('customer_id', auth()->user()->id)->get()->toArray();
        $finance = Financials::find($additionalData->financials_id);
        $keyManage = KeyManagements::find($additionalData->key_managements_id);
        $legal = LegalInformations::find($additionalData->legal_informations_id);
        $other = OtherDocuments::query()->where('customer_id', auth()->user()->id)->get()->toArray();
        $addressRecord = Address::query()->where('customer_id', auth()->user()->id)->get()->toArray();
        $this->record['name'] = $physicalRecord->name;
        $this->record['email'] = $physicalRecord->email;
        $this->record['name_of_the_company'] = $physicalRecord->name_of_the_company;
        $this->record['group_company_of'] = $physicalRecord->group_company_of;
        $this->record['website'] = $physicalRecord->website;

        $address = [];
        foreach ($addressRecord as $key => $value) {
            $value['country_id'] = Country::query()->where('id', $value['country_id'])->value('country_name');
            $address[$key] = $value;
        }
        $this->record['Address'] = $address;


        $bankInformations = [];
        foreach ($bank as $key => $value) {
            if ($value['bank_preferred'] == 1) {
                $value['bank_preferred'] = 'Yes';
            } else {
                $value['bank_preferred'] = 'No';
            }
            if ($value['has_banking_facilities'] == 1) {
                $value['has_banking_facilities'] = 'Yes';
            } else {
                $value['has_banking_facilities'] = 'No';
            }
            $value['bank_id'] = Bank::query()->where('id', $value['bank_id'])->value('bank_name');
            $value['branch_id'] = Branch::query()->where('id', $value['branch_id'])->value('branch_name');
            $value['country_id'] = Country::query()->where('id', $value['country_id'])->value('country_name');
            $value['currency_id'] = Currency::query()->where('id', $value['currency_id'])->value('currency_name');
            $bankInformations[$key] = $value;
        }
        // dd($bankInformations);
    
        $this->record['Bank Information'] = $bankInformations;


        $businessRecord=[];
        foreach($business as $key=>$value){
            $value['company_types_id']=CompanyTypes::query()->where('id',$value['company_types_id'])->value('company_type_name');
            $businessRecord[$key]=$value;
        }
                $this->record['Business References']=$businessRecord;

        $this->record['approx_turnover_for_last_year'] = $finance->approx_turnover_for_last_year;
        $this->record['name_of_auditor'] = $finance->name_of_auditor;
        $this->record['finance_contact_person'] = $finance->finance_contact_person;
        $this->record['finance_email_address'] = $finance->finance_email_address;
        $this->record['finance_telephone_number'] = $finance->finance_telephone_number;
        $this->record['finance_mobile_number'] = $finance->finance_mobile_number;

        $this->record['ceo_contact_name'] = $keyManage->ceo_contact_name;
        $this->record['ceo_contact_email_address'] = $keyManage->ceo_contact_email_address;
        $this->record['ceo_contact_phone_number'] = $keyManage->ceo_contact_phone_number;
        $this->record['cfo_contact_name'] = $keyManage->cfo_contact_name;
        $this->record['cfo_contact_email_address'] = $keyManage->cfo_contact_email_address;
        $this->record['cfo_contact_phone_number'] = $keyManage->cfo_contact_phone_number;
        // $this->record['owner_address'] = $keyManage->owner_address;
        $this->record['owner_contact_name'] = $keyManage->owner_contact_name;
        $this->record['owner_contact_email_address'] = $keyManage->owner_contact_email_address;
        $this->record['owner_contact_phone_number'] = $keyManage->owner_contact_phone_number;
        $this->record['payment_contact_name'] = $keyManage->payment_contact_name;
        $this->record['payment_contact_email_address'] = $keyManage->payment_contact_email_address;
        $this->record['payment_contact_phone_number'] = $keyManage->payment_contact_phone_number;
        $this->record['authorized_contact_name'] = $keyManage->authorized_contact_name;
        $this->record['authorized_contact_email_address'] = $keyManage->authorized_contact_email_address;
        $this->record['authorized_contact_phone_number'] = $keyManage->authorized_contact_phone_number;
        $this->record['any_other_remarks'] = $keyManage->any_other_remarks;

        $this->record['certificate_of_incorporation'] = $legal->certificate_of_incorporation;
        $this->record['certificate_of_incorporation_issue_date'] = $legal->certificate_of_incorporation_issue_date;
        $this->record['business_permit_issue_expiry_date'] = $legal->business_permit_issue_expiry_date;
        $this->record['business_permit_number'] = $legal->business_permit_number;
        $this->record['pin_number'] = $legal->pin_number;
        $this->record['certificate_of_incorporation_copy'] = $legal->certificate_of_incorporation_copy;
        $this->record['years_in_business'] = $legal->years_in_business;
        $this->record['pin_certificate_copy'] = $legal->pin_certificate_copy;
        $this->record['business_permit_copy'] = $legal->business_permit_copy;
        $this->record['cr12_documents'] = $legal->cr12_documents;
        $this->record['passport_ceo'] = $legal->passport_ceo;
        $this->record['passport_photo_ceo'] = $legal->passport_photo_ceo;
        $this->record['statement'] = $legal->statement;

        $otherDoc=[];
        foreach($other as $key=>$value){
            $value['document_types_id']=DocumentTypes::query()->where('id',$value['document_types_id'])->value('document_type_name');
            $otherDoc[$key]=$value;
        }
        $this->record['Other Documents'] =$otherDoc;
        return  array_merge(parent::getViewData());
    }
    public  function infolist(Infolist $infolist): Infolist
    {

        $physical = PhysicalInformations::find($this->getRecord()->physical_informations_id);
        // dd($this->getRecord());
        return $infolist
            // ------------------------------------------------Physical Info--------------------------------------------------------------
            ->schema([
                Section::make('PHYSICAL INFORMATION')
                    ->schema([
                        TextEntry::make('customer_number')->label('Customer Number')
                        ->default(function(){
                            $record=$this->getRecord();
                            $customerNumber=Customer::query()->where('id',$record->customer_id)->value('customer_number');
                            if($customerNumber!=null){
                                return $customerNumber;
                            }
                            else{
                                return null;
                            }
                           
                        })
                        ->visible(function ($state) {
                            if ($state == null) {
                                return false;
                            }
                            else{
                                return true;
                            }
                        }),
                        TextEntry::make('name')->label('Name'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('name_of_the_company')->label('Name Of Company'),
                        TextEntry::make('group_company_of')->label('Group Company'),
                        TextEntry::make('website')->label('Website'),
                        TextEntry::make('site_status')->label('Site Status')
                        ->badge()->default(function (Model $record) {
                            if ($record->customer_oracle_sync_site == "1") {
                                return 'Site Approved';
                            } else if ($record->status->value == 'rejected') {
                                return 'Site Rejected';
                            } else {
                                return 'Site is Pending Approval';
                            }
                        })
                        ->color(fn (string $state): string => match ($state) {
                            'Site Approved' => 'success',
                            'Site is Pending Approval' => 'warning',
                            'Site Rejected' => 'danger',
                        }),
                    ])->columns(2),

                    // -----------------------------------------legal information----------------------------

                    Section::make('LEGAL INFORMATION')
                            ->schema([
                                TextEntry::make('certificate_of_incorporation')->label('Incorporation Certificate'),
                                TextEntry::make('certificate_of_incorporation_issue_date')->label('Incorporation Certificate Issue Date')
                                    ->getStateUsing(function ($record) {
                                        return Carbon::parse($record->certificate_of_incorporation_issue_date)->format('d-m-Y');
                                    }),
                                TextEntry::make('business_permit_issue_expiry_date')->label('Business Permit Expiry Date')
                                    ->getStateUsing(function ($record) {
                                        return Carbon::parse($record->business_permit_issue_expiry_date)->format('d-m-Y');
                                    }),
                                TextEntry::make('business_permit_number')->label('Business Permit Number'),
                                TextEntry::make('pin_number')->label('Pin Certificate Number'),
                                TextEntry::make('years_in_business')->label('Years in Business'),
                               
                            ])->columns(2),

                // ---------------------------------------------Bank Info-----------------------------------------------------------------------
                Section::make('BANK INFORMATION')
                ->headerActions([
                        Action::make('Add')
                    ->visible(function(){
                        $site=$this->getRecord();
                        if($site->customer_oracle_sync_site==1){
                            return true;
                        }
                    })
                        ->form([
                            ComponentsSection::make('Bank Information')
                                ->schema([
                                    Select::make('currency_id')
                                        ->label('Currency')
                                        ->options(fn (Get $get): Collection => Currency::query()
                                            ->where('currency_status', '1')
                                            ->pluck('currency_name', 'id'))
                                        ->required(),


                                        Select::make('bank_id')
                                            ->options(fn (Get $get): Collection => Bank::query()
                                                ->where('bank_status', '1')
                                                ->pluck('Bank_name', 'id'))
                                            ->label('Bank')
                                            ->preload()
                                            ->live()
                                            ->afterStateUpdated(fn ($state, Set $set) => $set('bank_code', Bank::find($state)?->bank_code ?? 0))
                                            ->required()
                                            ->createOptionForm([
                                            TextInput::make('bank_name')
                                            ->label('Bank')
                                            ->regex('/^[a-zA-Z\s]+$/')
                                            ->required(),
                                            TextInput::make('bank_code')
                                            ->label('Bank Code')
                                            ->regex('/^[0-9\s]+$/')
                                            ->required(),  
                                            TextInput::make('bank_status')
                                            ->label('Bank Status')
                                            ->default(1)->readOnly(),
                                            ]) ->createOptionUsing(function ($data) {
                                                return Bank::create($data)->id;
                                                
                                            }),


                                    // Select::make('bank_id')
                                    //     ->options(fn (Get $get): Collection => Bank::query()
                                    //         ->where('bank_status', '1')
                                    //         ->pluck('Bank_name', 'id'))

                                    //     ->label('Bank')
                                    //     ->preload()
                                    //     ->live()
                                    //     ->required(),


                                    TextInput::make('bank_holder_name')
                                        ->label('Bank Holder Name')
                                        ->regex('/^[a-zA-Z\s]+$/')
                                        ->required(),


                                    // Select::make('branch_id')
                                    //     // ->relationship(name:'branch',titleAttribute:'branch_name'),
                                    //     ->options(fn (Get $get): Collection => Branch::query()
                                    //         ->where('bank_id', $get('bank_id'))
                                    //         ->where('branch_status', '1')
                                    //         ->pluck('branch_name', 'id'))
                                    //     ->afterStateUpdated(fn ($state, Set $set) => $set('bank_code', Branch::find($state)?->branch_code ?? 0))
                                    //     ->label('Branch Name')
                                    //     ->preload()
                                    //     ->live()
                                    //     ->required(),

                                    Select::make('branch_id')
                                            ->options(fn (Get $get): Collection => Branch::query()
                                                ->where('bank_id', $get('bank_id'))
                                                ->where('branch_status', '1')
                                                ->pluck('branch_name', 'id'))
                                            
                                            ->label('Branch Name')
                                            ->preload()
                                            ->live()
                                            ->required()
                                            ->createOptionForm([
                                                TextInput::make('branch_name')
                                                ->required()
                                            ->label('Branch Name')
                                            ->regex('/^[a-zA-Z\s]+$/')
                                            ->required(),
                                            TextInput::make('branch_code')
                                            ->required()
                                            ->label('Branch Code')
                                            ->regex('/^[0-9\s]+$/')
                                            ->required(),
                                            TextInput::make('branch_status')
                                            ->required()
                                            ->label('Bank Status')
                                            ->default(1)->readOnly(), 
                                            Select::make('bank_id')
                                            ->required()
                                            ->options(fn (Get $get): Collection => Bank::query()
                                                ->where('bank_status', '1')
                                                ->pluck('Bank_name', 'id'))
                                            ])->createOptionUsing(function ($data) { 
                                                return Branch::create($data)->id;
                                            }),


                                    TextInput::make('bank_account_number')
                                        ->label('Account Number')
                                        ->regex('/^[0-9\s]+$/')
                                        ->required(),
                                    TextInput::make('bank_code')
                                        ->label('Bank Code')
                                        ->regex('/^[0-9\s]+$/')
                                        ->readonly()
                                        ->HelperText("Read Only")
                                        ->extraInputAttributes([
                                            'style' => 'background-color: #f0f0f0; color: #333;',
                                        ])
                                        ->required(),
                                    TextInput::make('bank_iban')
                                        ->label('IBAN')
                                        ->regex('/^[a-zA-Z0-9\s]+$/')
                                        ->HelperText("Accept Number & Text"),
                                    Select::make('country_id')
                                        ->label('Country')
                                        ->options(fn (Get $get): Collection => country::query()
                                            ->where('country_status', '1')
                                            ->pluck('country_name', 'id'))
                                        ->required(),
                                    FileUpload::make('bank_details')
                                        ->label('Bank Details')
                                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv'])
                                        ->HelperText("Supported file -> JPEG, JPG, PNG & PDF, Excel, Csv Maximum size -> 1MB")
                                        ->maxSize(1000) // Set max size to 10MB
                                        ->preserveFilenames(), // Make the file publicly readable
                                    TextInput::make('bank_swift')
                                        ->label('Swift')
                                        ->maxlength(11)
                                        ->regex('/^[0-9\s]+$/')
                                        ->helperText('Accept Only Numbers'),
                                    Checkbox::make('bank_preferred')
                                        ->label('Preferred Bank')
                                        ->reactive()
                                    // ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                    //     if ($state) {
                                    //         $banks = $get('bank_information') ?? [];
                                    //         foreach ($banks as &$bank) {
                                    //             if ($bank['bank_preferred'] ?? false) {
                                    //                 $bank['bank_preferred'] = false;
                                    //             }
                                    //         }
                                    //         $banks[array_search($state, $banks)]['bank_preferred'] = true;
                                    //         $set('bank_information', $banks);
                                    //     }
                                    // })
                                    ,
                                    Radio::make('has_banking_facilities')
                                        ->label('Any Banking Facilities Available')
                                        ->afterStateUpdated(fn ($state, Set $set) => $set('banking_facilities_details', ' ' ?? ''))
                                        ->options([
                                            '1' => 'Yes',
                                            '0' => 'No',
                                        ])
                                        ->Inline()
                                        ->live()
                                        ->required(),
                                    Textarea::make('banking_facilities_details')
                                        ->label('Banking Facilities')
                                        ->visible(fn (Get $get): bool => $get('has_banking_facilities') == '1')
                                        ->regex('/^[a-zA-Z\s]+$/')
                                        ->required(),
                                ])->columns(2),
                        ])
                        ->button()
                        ->color('success')
                        ->action(function($data){
                            $data['customer_id']=auth()->user()->id;
                            if($data['bank_preferred']==1)
                            {
                                $banks=BankInformations::query()->where('customer_id',auth()->user()->id)->get()??'';
                                foreach($banks as $key => $value)
                                {
                                    $bank=BankInformations::find($value['id']);
                                    $bank->bank_preferred=0;
                                    $bank->update();
                                }
                            }
                            $bank=BankInformations::create($data);

                            $site = $this->getRecord();


                            $firstRole=ProcessApprovalFlow::query()->orderBy('id','asc')->pluck('role_id')->first();
                            $users=User::role($firstRole)->pluck('id')->toArray();
                            foreach($users as $user) {
                                ApprovalStatus::create([
                                    'customer_sites_id'=>$site->id,
                                    'user_id'=>$user,
                                    'status'=>ApprovelStatus::PROCESSING,
                                ]);

                            }

                            $site->status = ApplicationStatus::SUBMITTED;
                            $site->approval_flow = 1;
                            $site->customer_oracle_sync_site=0;
                            $site->update_type=2;
                            $site->update();

                            Notification::make()
                                ->title('Submitted successfully')
                                ->success()
                                ->send();
                            return true;
                        }),
                ])

                    ->schema([
                        RepeatableEntry::make('Bank Information')
                            ->schema([
                                TextEntry::make('currency_id')->label('Currency'),
                                TextEntry::make('bank_id')->label('Bank'),
                                TextEntry::make('bank_holder_name')->label('Bank Holder Name'),
                                TextEntry::make('branch_id')->label('Branch Name'),
                                TextEntry::make('bank_account_number')->label('Account Number'),
                                TextEntry::make('bank_code')->label('Bank Code'),
                                TextEntry::make('bank_iban')->label('Bank IBAN'),
                                TextEntry::make('country_id')->label('Country'),
                                TextEntry::make('bank_details')->label('Bank Details')
                                    ->suffixActions([
                                               Action::make('Download')
                                            ->icon('heroicon-o-arrow-down-tray')
                                            ->url(function (TextEntry $component) {
                                                $file = $component->getState();
                                                // dd($file);
                                                return route('download', $file);
                                        })
                                        ->iconButton()
                                        ->badge()
                                    ]),
                                TextEntry::make('bank_swift')->label('Bank Swift'),
                                TextEntry::make('bank_preferred')->label('Is Prefered'),
                                TextEntry::make('has_banking_facilities')->label('Any Banking Facilities Available'),
                                TextEntry::make('banking_facilities_details')->label('Banking Facilities')->visible(function($state){
                                    if($state==null){
                                        return false;
                                    }
                                    else{
                                        
                                        return true;
                                    }
                                }),
                            ])->columns(2)
                    ]),

                // -----------------------------------------------Business Reference -------------------------------------------------------------

                Section::make('BUSINESS REFERENCES')
                // ->headerActions([
                
                //     Action::make('Add')
                //     ->visible(function(){
                //         $site=$this->getRecord();
                //         if($site->status==ApplicationStatus::APPROVED){
                //             return true;
                //         }
                //     })
                //     ->form([
                //         ComponentsSection::make('Business References')
                //         ->schema([
                //             TextInput::make('name_of_company')
                //                     ->label('Company Name')
                //                     ->required()
                //                     ->regex('/^[a-zA-Z0-9\s]+$/'),
                //                 TextInput::make('name_of_the_contact_person')->label('Contact Person')->required()->regex('/^[a-zA-Z\s]+$/'),
                //                 TextInput::make('email_address')
                //                     ->label('Email')
                //                     ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                //                     ->email(),
                //                 TextInput::make('telephone_number')->label('Telephone Number')->required()->tel()->minLength(8),
                //                 TextInput::make('mobile_number')->label('Mobile Number')->required()->tel()->minLength(8),
                //                 Select::make('company_types_id')
                //                     ->options(fn (Get $get): Collection => CompanyTypes::query()
                //                         ->where('legal_information_restriction', '1')
                //                         ->pluck('company_type_name', 'id'))
                //                         ->label('Company Types')
                //                     ->required(),
                //                 TextInput::make('year_relationship')->label('Years in Relationship')->required(),
                //         ])->columns(2),
                //     ])
                //     ->button()
                //         ->color('success')
                //         ->action(function($data){
                //             $data['customer_id']=auth()->user()->id;
                //             $business=BusinessReferences::create($data);

                //             $site = $this->getRecord();


                //             $firstRole=ProcessApprovalFlow::query()->orderBy('id','asc')->pluck('role_id')->first();
                //             $users=User::role($firstRole)->pluck('id')->toArray();
                //             foreach($users as $user) {
                //                 ApprovalStatus::create([
                //                     'customer_sites_id'=>$site->id,
                //                     'user_id'=>$user,
                //                     'status'=>ApprovelStatus::PROCESSING,
                //                 ]);

                //             }

                //             $site->status = ApplicationStatus::SUBMITTED;
                //             $site->approval_flow = 1;
                //             $site->update_type=3;

                //             $site->update();

                //             Notification::make()
                //                 ->title('Submitted successfully')
                //                 ->success()
                //                 ->send();
                //             return true;
                //         }),
                // ])
                    ->schema([
                        RepeatableEntry::make('Business References')
                            ->schema([
                                TextEntry::make('name_of_company')->label('Company Name'),
                                TextEntry::make('name_of_the_contact_person')->label('Contact Person'),
                                TextEntry::make('email_address')->label('Email'),
                                TextEntry::make('telephone_number')->label('Telephone Number'),
                                TextEntry::make('mobile_number')->label('Mobile Number'),
                                TextEntry::make('company_types_id')->label('Company Types'),
                            ])->columns(2),
                        
                    ]),

                // --------------------------------------------Financials ----------------------------------------------------------------------------
                Section::make('FINANCIAL INFORMATION')
                    ->schema([
                        TextEntry::make('approx_turnover_for_last_year')->label('Approx Turnover for Last Year (Kenyan Shilling)'),
                        TextEntry::make('name_of_auditor')->label('Auditor Name'),
                        TextEntry::make('finance_contact_person')->label('Contact Person Name'),
                        TextEntry::make('finance_email_address')->label('Email'),
                        TextEntry::make('finance_telephone_number')->label('Telephone Number'),
                        TextEntry::make('finance_mobile_number')->label('Mobile Number'),
                    ])->columns(2),

                // ---------------------------------------------Key Managment----------------------------------------------------------
                Section::make('KEY MANAGEMENT')
                    ->schema([
                        Section::make('Name Of The Owner')
                            ->schema([
                                TextEntry::make('owner_contact_name')->label('Owner Name'),
                                TextEntry::make('owner_contact_email_address')->label('Owner Email'),
                                TextEntry::make('owner_contact_phone_number')->label('Owner Phone Number'),

                            ])->columns(3),
                        Section::make('Name Of CEO/GM')
                            ->schema([
                                TextEntry::make('ceo_contact_name')->label('CEO/GM Name'),
                                TextEntry::make('ceo_contact_email_address')
                                    ->label('Contact Email Address'),
                                TextEntry::make('ceo_contact_phone_number')->label('Contact Phone Number'),
                            ])->columns(3),
                        Section::make('Name Of CFO/FM')
                            ->schema([
                                TextEntry::make('cfo_contact_name')->label('CFO/FM Name'),
                                TextEntry::make('cfo_contact_email_address')
                                    ->label('Contact Email Address'),
                                TextEntry::make('cfo_contact_phone_number')->label('Contact Phone Number'),
                            ])->columns(3),
                        Section::make('Name Of Person to follow up for Payment')
                            ->schema([
                                TextEntry::make('payment_contact_name')->label('Contact Name'),
                                TextEntry::make('payment_contact_email_address')
                                    ->label('Contact Email Address'),
                                TextEntry::make('payment_contact_phone_number')->label('Contact Phone Number'),
                            ])->columns(3),
                        Section::make('Name Of Person Authorized to place PO')
                            ->schema([
                                TextEntry::make('authorized_contact_name')->label('Contact Name'),
                                TextEntry::make('authorized_contact_email_address')
                                    ->label('Contact Email Address'),
                                TextEntry::make('authorized_contact_phone_number')->label('Contact Phone Number'),
                                TextEntry::make('any_other_remarks')->label('Any Other Remarks'),
                            ])->columns(3),
                    ]),

                // -------------------------------------------Legal Information---------------------------------------------------------

                        



                            Section::make('CUSTOMER DOCUMENTS')
                                    ->schema([
                                        TextEntry::make('certificate_of_incorporation_copy')
                                        ->suffixActions([
                                             Action::make('Download')
                                            ->icon('heroicon-o-arrow-down-tray')
                                            ->url(function (TextEntry $component) {
                                                $file = $component->getState();
                                                // dd($file);
                                                return route('download', $file);
                                        })
                                        ->iconButton()
                                        ->badge()
                                        ]),
                                    TextEntry::make('pin_certificate_copy')
                                        ->suffixActions([
                                               Action::make('Download')
                                            ->icon('heroicon-o-arrow-down-tray')
                                            ->url(function (TextEntry $component) {
                                                $file = $component->getState();
                                                // dd($file);
                                                return route('download', $file);
                                        })
                                        ->iconButton()
                                        ->badge()
                                        ]),
                                    TextEntry::make('business_permit_copy')->label('Business Permit Copy')
                                        ->suffixActions([
                                              Action::make('Download')
                                            ->icon('heroicon-o-arrow-down-tray')
                                            ->url(function (TextEntry $component) {
                                                $file = $component->getState();
                                                // dd($file);
                                                return route('download', $file);
                                        })
                                        ->iconButton()
                                        ->badge()
                                        ]),
                                    TextEntry::make('cr12_documents')->label('CR12 Document')
                                        ->suffixActions([
                                               Action::make('Download')
                                            ->icon('heroicon-o-arrow-down-tray')
                                            ->url(function (TextEntry $component) {
                                                $file = $component->getState();
                                                // dd($file);
                                                return route('download', $file);
                                        })
                                        ->iconButton()
                                        ->badge()
                                        ]),
                                    TextEntry::make('passport_ceo')->label('Passport/National ID of Director/CEO')
                                        ->suffixActions([
                                              Action::make('Download')
                                            ->icon('heroicon-o-arrow-down-tray')
                                            ->url(function (TextEntry $component) {
                                                $file = $component->getState();
                                                // dd($file);
                                                return route('download', $file);
                                        })
                                        ->iconButton()
                                        ->badge()
                                        ]),
                                    TextEntry::make('passport_photo_ceo')->label('Passport size Photo of Director/ CEO ')
                                        ->suffixActions([
                                               Action::make('Download')
                                            ->icon('heroicon-o-arrow-down-tray')
                                            ->url(function (TextEntry $component) {
                                                $file = $component->getState();
                                                // dd($file);
                                                return route('download', $file);
                                        })
                                        ->iconButton()
                                        ->badge()
                                        ]), TextEntry::make('statement')->label('Bank Statement')
                                        ->suffixActions([
                                               Action::make('Download')
                                            ->icon('heroicon-o-arrow-down-tray')
                                            ->url(function (TextEntry $component) {
                                                $file = $component->getState();
                                                // dd($file);
                                                return route('download', $file);
                                        })
                                        ->iconButton()
                                        ->badge()
                                        ])->columns(2)
                                            ]),
                        // ------------------------------------------------------Other Documents-------------------------------------------------
                        Section::make('OTHER DOCUMENTS')
                        // ->headerActions([
                        //     Action::make('Add')
                        //     ->visible(function(){
                        //         $site=$this->getRecord();
                        //         if($site->status==ApplicationStatus::APPROVED){
                        //             return true;
                        //         }
                        //     })
                        //         ->form([
                        //             ComponentsSection::make('Other Documents')
                        //                 ->schema([
                        //                     Select::make('document_types_id')->label('Document Name')
                        //                     ->options(fn (Get $get): Collection => DocumentTypes::query()
                        //                         ->where('document_type_status', '1')
                        //                         ->pluck('document_type_name', 'id'))
                        //                     ->required(),
                        //                 FileUpload::make('document')
                        //                     ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'])
                        //                     ->helpertext("Supported file -> JPEG,JPG,PNG & PDF, Maximum size -> 10MB")
                        //                     ->maxSize(10000)
                        //                     ->preserveFilenames()
                        //                     ->label('Document')
                        //                     ->required(),
                        //                 Textarea::make('description')
                        //                     ->label('Description'),
                        //                 ])->columns(2),
                        //         ])
                        //         ->button()
                        //         ->color('success')
                        //         ->action(function($data){
                        //             $data['customer_id']=auth()->user()->id;
                        //             $other=OtherDocuments::create($data);
    
                        //             $site = $this->getRecord();

                        //             $firstRole=ProcessApprovalFlow::query()->orderBy('id','asc')->pluck('role_id')->first();
                        //             $users=User::role($firstRole)->pluck('id')->toArray();
                        //             foreach($users as $user) {
                        //                 ApprovalStatus::create([
                        //                     'customer_sites_id'=>$site->id,
                        //                     'user_id'=>$user,
                        //                     'status'=>ApprovelStatus::PROCESSING,
                        //                 ]);
        
                        //             }
                        //             $site->status = ApplicationStatus::SUBMITTED;
                        //             $site->approval_flow = 1;
                        //             $site->update_type=4;
                        //             $site->update();
    
                        //             Notification::make()
                        //                 ->title('Submitted successfully')
                        //                 ->success()
                        //                 ->send();
                        //             return true;
                        //         }),
                        // ])
                            ->schema([
                                RepeatableEntry::make('Other Documents')
                                    ->schema([
                                        TextEntry::make('document_types_id')->label('Document Name'),
                                        TextEntry::make('document')->label('Document')->suffixActions([
                                              Action::make('Download')
                                            ->icon('heroicon-o-arrow-down-tray')
                                            ->url(function (TextEntry $component) {
                                                $file = $component->getState();
                                                // dd($file);
                                                return route('download', $file);
                                        })
                                        ->iconButton()
                                        ->badge()
                                ]),
                                TextEntry::make('description')->label('Description'),
                            ])
                    ]),
                // -----------------------------------------------customer sites------------------------------------------------------

                Section::make('CUSTOMER SITE')
                ->headerActions([
                    Action::make('Add')
                    ->visible(function(){
                        $site=$this->getRecord();
                        if($site->customer_oracle_sync_site == 1){
                            return true;
                        }
                    })
                        ->form([
                            ComponentsSection::make('Address')
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
                                                    // ->required()
                                                    ->label('Latitude')
                                                    ->readOnly(),
                                                TextInput::make('longitude')
                                                    // ->required()
                                                    ->label('Longitude')
                                                    ->readOnly(),
                                            ])->columnSpan(1) // Make the inputs take up one column
                                    ])
                                ])->columns(2)
                                  ->model(Address::class),
                        ])
                        ->button()
                        ->color('success')
                        ->action(function($data){
                            $data['customer_id']=auth()->user()->id;
                            if($data['country_id']!=110){
                                $data['kenya_cities_id']=null;
                                $data['territory_id']=null;
                               }
                               $address = Address::create([
                                'location_name' => $data['location_name'],
                                'address_1' => $data['address_1'],
                                'address_2' => $data['address_2'],
                                'address_3' => $data['address_3'],
                                'address_4' => $data['address_4'],
                                'latitude' => $data['latitude'],
                                'longitude' => $data['longitude'],
                                'location_type' => $data['location_type'],
                                'site_name' => $data['site_name'],
                                'country_id' => $data['country_id'],
                                'nearest_landmark' => $data['nearest_landmark'],
                                'companylandline_number' => $data['companylandline_number'],
                                'postal_code' => $data['postal_code'],
                                'payment_mode' => $data['payment_mode'],
                                'kenya_cities_id' => $data['kenya_cities_id'],
                                'territory_id' => $data['territory_id'],
                                'customer_id' => $data['customer_id'],
                            ]);
                            

                            $site = $this->getRecord();

                            $firstRole=ProcessApprovalFlow::query()->orderBy('id','asc')->pluck('role_id')->first();
                            $users=User::role($firstRole)->pluck('id')->toArray();
                            foreach($users as $user) {
                                ApprovalStatus::create([
                                    'customer_sites_id'=>$site->id,
                                    'user_id'=>$user,
                                    'status'=>ApprovelStatus::PROCESSING,
                                ]);

                            }
                            $site->status = ApplicationStatus::SUBMITTED;
                            $site->approval_flow = 1;
                            $site->customer_oracle_sync_site=0;
                            $site->address_id=$address->id;
                            $site->update_type=1;
                            $site->update();

                            Notification::make()
                                ->title('Submitted successfully')
                                ->success()
                                ->send();
                            return true;
                        }),
                ])

                    ->schema([
                        TextEntry::make('site_status')->label('Site Status')
                            ->badge()->default(function (Model $record) {
                                if ($record->status->value == "approved") {
                                    return 'Site Approved';
                                } else if ($record->status->value == 'rejected') {
                                    return 'Site Rejected';
                                } else {
                                    return 'Site is Pending Approval';
                                }
                            })
                            ->color(fn (string $state): string => match ($state) {
                                'Site Approved' => 'success',
                                'Site is Pending Approval' => 'warning',
                                'Site Rejected' => 'danger',
                            }),
                            TextEntry::make('name')->label('Customer Name'),
                            RepeatableEntry::make('Address')
                            ->schema([
                                TextEntry::make('location_name')->label('Location Name'),
                                TextEntry::make('location_type')->label('Location Type'),
                                TextEntry::make('address_1')->label('Address 1'),
                                TextEntry::make('address_2')->label('Address 2'),
                                TextEntry::make('address_3')->label('Address 3'),
                                TextEntry::make('address_4')->label('Address 4'),
                                TextEntry::make('postal_code')->label('Postal Code'),
                                TextEntry::make('country_id')->label('Country'),
                                TextEntry::make('site_name')->label('Site Name'),
                                TextEntry::make('nearest_landmark')->label('Landmark'),
                                TextEntry::make('longitude')->label('Longitude'),
                                TextEntry::make('latitude')->label('Latitude'),
                                TextEntry::make('companylandline_number')->label('Landline Number'),
                                TextEntry::make('payment_mode')->label('Payment Mode'),
                            ])->columns(2),
                        
                    ]),
                
            ]);
    }
       public static function getDefaultCountryId()
    {
        $defaultCountry = Country::where('country_name', 'Kenya')->first();
        return $defaultCountry ? $defaultCountry->id : null;
    }
}
