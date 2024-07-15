<?php

namespace App\Filament\Resources\CustomerSitesResource\Pages;

use App\Enums\ApplicationStatus;
use App\Filament\Actions\Approve;
use App\Filament\Actions\Reject;
use App\Filament\Resources\CustomerSitesResource;
use App\Infolists\Components\Status;
use App\Models\AccountType;
use App\Models\Address;
use App\Models\ApprovalAnswers;
use App\Models\ApprovalComment;
use App\Models\ApprovalStatus;
use App\Models\Bank;
use App\Models\BankInformations;
use App\Models\Branch;
use App\Models\BusinessReferences;
use App\Models\Collector;
use App\Models\CompanyTypes;
use App\Models\Country;
use App\Models\KenyaCities;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerCategories;
use App\Models\DocumentTypes;
use App\Models\Financials;
use App\Models\KeyManagements;
use App\Models\LegalInformations;
use App\Models\OtherDocuments;
use App\Models\PhysicalInformations;
use App\Models\CustomerSites;
use App\Models\FreightTerms;
use App\Models\OrderType;
use App\Models\PaymentTerms;
use App\Models\PriceList;
use App\Models\Territory;
use App\Models\User;
use Carbon\Carbon;
use Collection;
use Exception;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Actions as ComponentsActions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use App\Models\ProcessApprovalFlow;
use App\Models\SalesRepresentative;
use App\Models\SalesTerritory;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Infolists\Components\KeyValueEntry;

class ViewCustomerSites extends ViewRecord
{
    protected static string $resource = CustomerSitesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Approve::make()
                ->visible(function (Model $record) {
                    /** @var App\Models\User $user */
                    $user = auth()->user();
                    $flow = (new ProcessApprovalFlow)->where('role_id', $user->roles->first()->id)->first();
                    if ($user->canApprove() && $flow?->order == $record->approval_flow && $record->status == ApplicationStatus::SUBMITTED) {
                        return true;
                    }
                    return false;
                }),
            Reject::make()
                ->visible(function (Model $record) {
                    /** @var App\Models\User $user */
                    $user = auth()->user();
                    $flow = (new ProcessApprovalFlow)->where('role_id', $user->roles->first()->id)->first();
                    if ($user->canReject() && $flow?->order == $record->approval_flow && $record->status == ApplicationStatus::SUBMITTED) {
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
        $bank = BankInformations::query()->where('customer_id', $additionalData->customer_id)->get()->toArray();
        $business = BusinessReferences::query()->where('customer_id',$additionalData->customer_id)->get()->toArray();
        $finance = Financials::find($additionalData->financials_id);
        $keyManage = KeyManagements::find($additionalData->key_managements_id);
        $legal = LegalInformations::find($additionalData->legal_informations_id);
        $other = OtherDocuments::query()->where('customer_id',$additionalData->customer_id)->get()->toArray();
        $addressRecord=Address::query()->where('customer_id',$additionalData->customer_id)->get()->toArray();



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
        $years = $this->record['years_in_business'] = $legal->years_in_business;
        if ($years == 0) {
            $this->record['years_in_business'] = '0 years';
        } else {
            $this->record['years_in_business'] = "0 to {$years} years";
        } 
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
                        TextEntry::make('customer_number')->label('Number')
                        ->visible(function ($state) {
                            if ($state == null) {
                                return false;
                            }
                        }),
                        TextEntry::make('name')->label('Name'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('name_of_the_company')->label('Name Of Company'),
                        TextEntry::make('group_company_of')->label('Group Company'),
                        TextEntry::make('website')->label('Website'),

                        TextEntry::make('Mobile Number')
                        ->default(function(){
                            $comments = CustomerSites::query()->where('id',$this->getRecord()->id)->value('customer_id');
                            if($comments==null){
                                return 'N/A';
                            }
                            else{
                                 $val= Customer::query()->where('id',$comments)->value('mobile');
                                 return  $val;
                            }
                        }  ),

                        TextEntry::make('Registration_date')->default($physical->created_at ?? ''), 
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
                    ])->columns(2),

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
                        TextEntry::make('pin_number')->label('Pin Number'),
                        TextEntry::make('years_in_business')->label('Years in Business'),
                        
                    ])->columns(2),


                // ---------------------------------------------Bank Info-----------------------------------------------------------------------
                Section::make('BANK INFORMATIONS')
                    ->schema([
                        RepeatableEntry::make('Bank Information')
                            ->schema([
                                TextEntry::make('currency_id')->label('Currency'),
                                TextEntry::make('bank_id')->label('Bank'),
                                TextEntry::make('bank_holder_name')->label('Bank Holder Name'),
                                TextEntry::make('branch_id')->label('Branch Name'),
                                TextEntry::make('bank_account_number')->label('Account Number'),
                                TextEntry::make('bank_code')->label('Bank Code'),
                                TextEntry::make('bank_iban')->label('IBAN'),
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
                                TextEntry::make('bank_swift')->label('Swift'),
                                TextEntry::make('bank_preferred')->label('Prefered Bank'),
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

                Section::make('CUSTOMER BUSINESS REFERENCES')
                    ->schema([
                        RepeatableEntry::make('Business References')
                            ->schema([
                                TextEntry::make('name_of_company')->label('Reference Company Name'),
                                TextEntry::make('name_of_the_contact_person')->label('Reference Person Name'),
                                TextEntry::make('email_address')->label('Reference Email'),
                                TextEntry::make('telephone_number')->label('Telephone Number'),
                                TextEntry::make('mobile_number')->label('Mobile Number'),
                                TextEntry::make('company_types_id')->label('Company Types'),
                            ])->columns(2),
                        ComponentsActions::make([
                            Action::make('Verify Questionnaire')
                                ->icon('heroicon-o-folder-arrow-down')
                                ->requiresConfirmation()
                                ->visible(function (Model $record) {
                                    $ans=ApprovalAnswers::query()->where('customer_sites_id',$record->id)->get()->count();
                                    $business=BusinessReferences::query()->where('customer_id',$record->customer_id)->get()->count();
                                    if ($ans < $business  && $record->approval_flow == ProcessApprovalFlow::query()->pluck('order')->first()) {
                                        return true;
                                    }
                                })
                                ->form([
                                    ComponentsSection::make('Questionnaire')
                                            ->schema([
                                                Select::make('business_references_id')
                                                ->label('Business Reference')
                                                ->afterStateUpdated(function($state,Set $set){
                                                    $set('answers_name',BusinessReferences::query()->where('id',$state)->value('name_of_the_contact_person'));
                                                    $set('answers_email',BusinessReferences::query()->where('id',$state)->value('email_address'));
                                                    $set('answers_mobile',BusinessReferences::query()->where('id',$state)->value('mobile_number'));
                                                    $set('year_relationship_supplier',BusinessReferences::query()->where('id',$state)->value('year_relationship'));
                                                })
                                                ->required()
                                                ->live()
                                                ->options(fn (Get $get): SupportCollection => BusinessReferences::query()->where('customer_id', $this->record->customer_id)->pluck('name_of_company', 'id')),
                                            TextInput::make('answers_name')->label('Name')
                                                ->readOnly(),
                                            TextInput::make('answers_email')->label('Email')
                                                ->readOnly(),
                                            TextInput::make('answers_mobile')->label('Phone Number')
                                                ->readOnly(),
                                            DateTimePicker::make('call_date_time')->label('Call Date & Time')                                            
                                            ->afterOrEqual(function(){
                                                $record=$this->getRecord();
                                                return $record->created_at;
                                            })
                                            ->required(),
                                            Textarea::make('questionnaire_remarks')->label('Questionnaire Remarks'),
                                            TextInput::make('year_relationship_supplier')->label('Years in Relationship mentioned by customer')->readOnly(),
                                            TextInput::make('year_relationship_customer')->label('Years in Relationship specified by customer')->required()
                                            ->lte('year_relationship_supplier'),
                                            Radio::make('payments')->label('Are Payments made on time?')
                                                ->required()
                                                ->options([
                                                    '1' => 'Yes',
                                                    '0' => 'No'
                                                ]),
                                            TextInput::make('volume_business')->label('Volume of business')->required(),
                                            TextInput::make('credit_period')->label('Credit Period')->required(),
                                            ])->columns(2)
                                            // ->helperText(function () {
                                            // $count = BusinessReferences::query()->where('customer_id', $this->record->id)->count();
                                            // return "Total Business References: $count. Please do not include additional View Questionnaire ";
                                        // })
                                ]) //form

                                ->modalWidth('3xl')
                                // ->modalHeading('Enter Details')
                                ->modalDescription('Please Fill the Form')
                                ->modalSubmitActionLabel('Yes, proceed')
                                ->action(function (array $data) {
                                        $data['customer_sites_id']=$this->getRecord()->id;
                                        ApprovalAnswers::create($data);
                                }),

                            ]),
                            ComponentsActions::make([
                                Action::make('View Questionnaire and Answers')
                                ->icon('heroicon-o-chat-bubble-oval-left-ellipsis')
                                ->modalSubmitAction(false)
                                ->visible(function(Model $record){
                                    $ans=ApprovalAnswers::query()->where('customer_sites_id',$record->id)->get()->first();
                                    if($ans!=null){
                                        return true;
                                    }
                                })
                                ->infolist([
                                    KeyValueEntry::make('Questionnaire')
                                    ->keyLabel('Question')
                                    ->valueLabel('Answer')
                                    ->getStateUsing(function(){
                                    
                                        $ans=ApprovalAnswers::query()->where('customer_sites_id',$this->getRecord()->id)->get()->toArray();
                                        $answers=[];
                                        $start=0;
                                        foreach($ans as $key=>$value){

                                            $companyId=BusinessReferences::query()->where('id',$value['business_references_id'])->value('company_types_id');
                                            // $year=BusinessReferences::query()->where('id',$value['business_references_id'])->value('company_types_id');
                                            if($value['payments']==1){
                                                $value['payments']='Yes';
                                            }
                                            else{
                                                $value['payments']='No';
                                            }
                                            $answers[$start]=[
                                                'Company Name'=>BusinessReferences::find($value['business_references_id'])->name_of_company,
                                                'Call Date & time'=>$value['call_date_time'],
                                                'Company Type Specified By Customer'=>CompanyTypes::query()->where('id',$companyId)->value('company_type_name'),
                                                'Years of Relationship specified by Supplier'=>$value['year_relationship_supplier'],
                                                'Years of Relationship specified by Customer'=>$value['year_relationship_customer'],
                                                'Are Payments Made on time?'=>$value['payments'],
                                                'Volume of Business'=>$value['volume_business'],
                                                'Credit Period'=>$value['credit_period'],
                                                'Remarks'=>$value['questionnaire_remarks'],
                                            ];
                                            $start++;
                                        }
                                        // dd($answers)
                                        return $answers;
                                    })
                                    ])
                                ->modalWidth('3xl')
                                ->modalHeading('View Details '),
                               
                            ]) 

                    ]),

                // --------------------------------------------Financials ----------------------------------------------------------------------------
                Section::make('FINANCIAL INFORMATION')
                    ->schema([
                        TextEntry::make('approx_turnover_for_last_year')->label('Approx Turnover for Last Year (Kenyan Shilling)'),
                        TextEntry::make('name_of_auditor')->label('Auditor Name'),
                        TextEntry::make('finance_contact_person')->label('Contact Person'),
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
                                TextEntry::make('ceo_contact_name')->label('CEO Name'),
                                TextEntry::make('ceo_contact_email_address')
                                    ->label('CEO Email'),
                                TextEntry::make('ceo_contact_phone_number')->label('CEO Phone Number'),
                            ])->columns(3),
                        Section::make('Name Of CFO/FM')
                            ->schema([
                                TextEntry::make('cfo_contact_name')->label('CFO Name'),
                                TextEntry::make('cfo_contact_email_address')
                                    ->label('CFO Email Address'),
                                TextEntry::make('cfo_contact_phone_number')->label('CFO Phone Number'),
                            ])->columns(3),
                        Section::make('Name Of Person to follow up for Payment')
                            ->schema([
                                TextEntry::make('payment_contact_name')->label('Followup Person Name'),
                                TextEntry::make('payment_contact_email_address')
                                    ->label('Followup Person Email Address'),
                                TextEntry::make('payment_contact_phone_number')->label('Followup Person Phone Number'),
                            ])->columns(3),
                        Section::make('Name Of Person Authorized to place PO')
                            ->schema([
                                TextEntry::make('authorized_contact_name')->label('Authorized To Place PO Person Name'),
                                TextEntry::make('authorized_contact_email_address')
                                    ->label('Authorized To Place PO Email'),
                                TextEntry::make('authorized_contact_phone_number')->label('Authorized To Place PO Phone Number'),
                                TextEntry::make('any_other_remarks')->label('Remarks'),
                            ])->columns(3),
                    ]),
// ---customersite

                    Section::make('CUSTOMER SITE')
                    ->schema([
                        Section::make('')
                        ->schema([
                        TextEntry::make('customer_number')->label('Number')
                        ->visible(function ($state) {
                            if ($state == null) {
                                return false;
                            }
                        }),
                        TextEntry::make('name')->label('Customer Name'),
                        TextEntry::make('approved_credit_value')->label('Credit Value')->default(function(){
                            $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->get()->last();
                            if($comments==null){
                                return 'N/A';
                            }
                            else{
                                return $comments->approved_credit_value;
    
                            }
                        }),
                        TextEntry::make('payment_terms_id')->label('Payment Terms')->default(function(){
                            $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->orderBy('id','desc')->first();
                            
                            if($comments==null){
                                return 'N/A';
                            }
                            else{
                                return PaymentTerms::query()->where('id',$comments->payment_terms_id)->value('payment_term_name');
    
                            }
                        }  ),
                        TextEntry::make('customer_categories_id')->label('Customer Class')->default(function(){
                            $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->get()->last();
                            if($comments==null){
                                return 'N/A';
                            }
                            else{
                                return CustomerCategories::query()->where('id',$comments->customer_categories_id)->value('customer_categories_name');
    
                            }
                        }),
                        TextEntry::make('freight_terms_id')->label('Freight Terms')->default(function(){
                            $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->get()->last();
                            if($comments==null){
                                return 'N/A';
                            }
                            else{
                                return FreightTerms::query()->where('id',$comments->freight_terms_id)->value('name');
    
                            }
                        }),
                        TextEntry::make('account_type_id')->label('Customer Type')->default(function(){
                            $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->orderBy('id','desc')->first();
                            if($comments==null){
                                return 'N/A';
                            }
                            else{
                                return AccountType::query()->where('id',$comments->account_type_id)->value('type');
    
                            }
                        }),

                        TextEntry::make('sales_territory_id')->label('Sales Territory')->default(function(){
                            $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->get()->last();
                            if($comments==null){
                                return 'N/A';
                            }
                            else{
                                return SalesTerritory::query()->where('id',$comments->sales_territory_id)->value('sales_territory');
    
                            }
                        }),
                        TextEntry::make('sales_representative_id')->label('Sales Representative')->default(function(){
                            $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->get()->last();
                            if($comments==null){
                                return 'N/A';
                            }
                            else{
                                return SalesRepresentative::query()->where('id',$comments->sales_representative_id)->value('sales_representative');
    
                            }
                        }),
                        TextEntry::make('collector_id')->label('Collector')->default(function(){
                            $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->orderBy('id','desc')->first();
                            if($comments==null){
                                return 'N/A';
                            }
                            else{
                                return Collector::query()->where('id',$comments->collector_id)->value('collector_name');
    
                            }
                        }),

                        TextEntry::make('price_list_id')->label('Price List')->default(function(){
                            $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->get()->last();
                            if($comments==null){
                                return 'N/A';
                            }
                            else{
                                return PriceList::query()->where('id',$comments->price_list_id)->value('Price_list_name');
    
                            }
                        }),
                        TextEntry::make('order_type_id')->label('OrderType')->default(function(){
                            $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->orderBy('id','desc')->first();
                            if($comments==null){
                                return 'N/A';
                            }
                            else{
                                return OrderType::query()->where('id',$comments->order_type_id)->value('order_type');
    
                            }
                        }),
                        ])->columns(2),
  
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

                    // Section::make('ADDITIONAL INFORMATION')
                    //         ->schema([
                                               
                    //         TextEntry::make('payment_terms_id')->label('Payment Terms')->default(function(){
                    //         $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->orderBy('id','desc')->first();
                            
                    //         if($comments==null){
                    //             return 'N/A';
                    //         }
                    //         else{
                    //             return PaymentTerms::query()->where('id',$comments->payment_terms_id)->value('payment_term_name');
    
                    //         }
                    //     }  ),
                    //     TextEntry::make('customer_categories_id')->label('Customer Class')->default(function(){
                    //         $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->get()->last();
                    //         if($comments==null){
                    //             return 'N/A';
                    //         }
                    //         else{
                    //             return CustomerCategories::query()->where('id',$comments->customer_categories_id)->value('customer_categories_name');
    
                    //         }
                    //     }),
                    //     TextEntry::make('freight_terms_id')->label('Freight Terms')->default(function(){
                    //         $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->get()->last();
                    //         if($comments==null){
                    //             return 'N/A';
                    //         }
                    //         else{
                    //             return FreightTerms::query()->where('id',$comments->freight_terms_id)->value('name');
    
                    //         }
                    //     }),
                    //     TextEntry::make('account_type_id')->label('Customer Type')->default(function(){
                    //         $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->orderBy('id','desc')->first();
                    //         if($comments==null){
                    //             return 'N/A';
                    //         }
                    //         else{
                    //             return AccountType::query()->where('id',$comments->account_type_id)->value('type');
    
                    //         }
                    //     }),

                    //     TextEntry::make('sales_territory_id')->label('Sales Territory')->default(function(){
                    //         $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->get()->last();
                    //         if($comments==null){
                    //             return 'N/A';
                    //         }
                    //         else{
                    //             return SalesTerritory::query()->where('id',$comments->sales_territory_id)->value('sales_territory');
    
                    //         }
                    //     }),
                    //     TextEntry::make('sales_representative_id')->label('Sales Representative')->default(function(){
                    //         $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->get()->last();
                    //         if($comments==null){
                    //             return 'N/A';
                    //         }
                    //         else{
                    //             return SalesRepresentative::query()->where('id',$comments->sales_representative_id)->value('sales_representative');
    
                    //         }
                    //     }),
                    //     TextEntry::make('collector_id')->label('Collector')->default(function(){
                    //         $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->orderBy('id','desc')->first();
                    //         if($comments==null){
                    //             return 'N/A';
                    //         }
                    //         else{
                    //             return Collector::query()->where('id',$comments->collector_id)->value('collector_name');
    
                    //         }
                    //     }),

                    //     TextEntry::make('price_list_id')->label('Price List')->default(function(){
                    //         $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->get()->last();
                    //         if($comments==null){
                    //             return 'N/A';
                    //         }
                    //         else{
                    //             return PriceList::query()->where('id',$comments->price_list_id)->value('Price_list_name');
    
                    //         }
                    //     }),
                    //     TextEntry::make('order_type_id')->label('OrderType')->default(function(){
                    //         $comments = ApprovalComment::query()->where('customer_sites_id',$this->getRecord()->id)->orderBy('id','desc')->first();
                    //         if($comments==null){
                    //             return 'N/A';
                    //         }
                    //         else{
                    //             return OrderType::query()->where('id',$comments->order_type_id)->value('order_type');
    
                    //         }
                    //     }),




                    //             ])->columns(2),
               
                    Section::make('CUSTOMER DOCUMENTS')
                    ->schema([
                        TextEntry::make('certificate_of_incorporation_copy')
                        ->label('1. Certificate of Incorporation')
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
                        ->label('2. Pin Registration Certificate')
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
                        TextEntry::make('business_permit_copy')->label('3. Business Permit')
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
                        TextEntry::make('cr12_documents')->label('4. CR12 Documents')
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
                        TextEntry::make('passport_ceo')->label('5. Passport/National ID of Director/CEO')
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
                        TextEntry::make('passport_photo_ceo')->label('6. Passport size Photo of Director/ CEO ')
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
                            ]), TextEntry::make('statement')->label('7. Bank Statement')
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
                            ])->columns(2),
                        ]),

                // ------------------------------------------------------Other Documents-------------------------------------------------
                Section::make('OTHER DOCUMENT')
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

                
                Section::make('CUSTOMER STATUS')
                    ->schema([
                        Status::make('')
                            ->view('infolists.components.status'),
                    ]),

            ]);
    }
    public function getTableData(): array
    {
        $statusArray = [];
        $statusTable = ApprovalStatus::query()->where('customer_sites_id', $this->getRecord()->id)->get()->toArray();
        $start = 0;
        foreach ($statusTable as $key => $value) {
            if ($value['status'] == 'approved') {
                $value['status'] = 'Approved by ' . User::query()->where('id', $value['user_id'])->value('name');
                $value['statuss'] = User::query()->where('id', $value['user_id'])->value('name');
            } else if ($value['status'] == 'rejected') {
                $value['status'] = 'Rejected by ' . User::query()->where('id', $value['user_id'])->value('name');
                $value['statuss'] = User::query()->where('id', $value['user_id'])->value('name');
            } else {
                $value['status'] = 'Pending verification from ' . User::query()->where('id', $value['user_id'])->value('name');
                $value['statuss'] = User::query()->where('id', $value['user_id'])->value('name');
            }
            $statusArray[$start] = [

                'status' => $value['status'],
                'updated_by' =>$value['statuss'],
                'updated_at' => Carbon::parse($value['updated_at']),
                'comment' => $value['comment'],
            ];
            $start++;
        }
        return $statusArray;
    }
}
