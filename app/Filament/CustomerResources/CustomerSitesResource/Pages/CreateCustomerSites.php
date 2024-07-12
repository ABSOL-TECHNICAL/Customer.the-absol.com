<?php

namespace App\Filament\CustomerResources\CustomerSitesResource\Pages;

use App\Filament\Notifications\ApplicationSubmit;
use App\Filament\CustomerResources\CustomerSitesResource;
use App\Models\Address;
use App\Models\BankInformations;
use App\Models\BusinessReferences;
use App\Models\Financials;
use App\Models\KeyManagements;
use App\Models\LegalInformations;
use App\Models\OtherDocuments;
use App\Models\PhysicalInformations;
use App\Models\Customer;
use App\Models\CustomerSites;
use App\Models\Documents;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Notifications\Notifiable;

class CreateCustomerSites extends CreateRecord
{
    use Notifiable;
    protected static string $resource = CustomerSitesResource::class;
    protected static bool $canCreateAnother = false;
    public string $email = '';
    public string $name = '';

    public function getFormActions(): array
    {
        return [
          
        ];
    }
    
    public function getRedirectUrl(): string
    {
       
        return $this->getResource()::getUrl('index');
    }
    public function mutateFormDataBeforeCreate(array $data): array{
        $physical=0;
        $bank=0;
        $address=0;
        $business=0;
        $finance=0;
        $keyManage=0;
        $legal=0;
        $other=0;
        $document=0;

                        $docRecord=new Documents();
                        $docRecord->certificate_of_incorporation_copy=$data['certificate_of_incorporation_copy'];
                        $docRecord->pin_certificate_copy=$data['pin_certificate_copy'];
                        $docRecord->business_permit_copy=$data['business_permit_copy'];
                        $docRecord->cr12_documents=$data['cr12_documents'];
                        $docRecord->passport_ceo=$data['passport_ceo'];
                        $docRecord->passport_photo_ceo=$data['passport_photo_ceo'];
                        $docRecord->statement=$data['statement'];
                        $docRecord->customer_id=auth()->user()->id;
                        $docs=Documents::create([
                            'certificate_of_incorporation_copy'=>$docRecord->certificate_of_incorporation_copy,
                            'pin_certificate_copy'=>$docRecord->pin_certificate_copy,
                                'business_permit_copy'=>$docRecord->business_permit_copy,
                                'cr12_documents'=>$docRecord->cr12_documents,
                                'passport_photo_ceo'=>$docRecord->passport_photo_ceo,
                                'passport_ceo'=>$docRecord->passport_ceo,
                                'statement'=> $docRecord->statement,
                                'bank_details'=>$docRecord->bank_details,
                                'document'=>$docRecord->document,
                                'customer_id'=>$docRecord->customer_id,
                                ]   
                            );
                            $document=$docs->id;
                    
        // dd($data);
                        $physicalRecord=new PhysicalInformations();
                        $physicalRecord->name=$data['name'];
                        $physicalRecord->email=$data['email'];
                        $physicalRecord->name_of_the_company=$data['name_of_the_company'];
                        $physicalRecord->group_company_of=$data['group_company_of'];
                        $physicalRecord->website=$data['website'];
                        $physicalRecord->customer_id=auth()->user()->id;
                        $phy=PhysicalInformations::create([
                            'name'=>$physicalRecord->name,
                            'email'=>$physicalRecord->email,
                            'name_of_the_company'=>$physicalRecord->name_of_the_company,
                            'group_company_of'=>$physicalRecord->group_company_of,
                            'website'=>$physicalRecord->website,
                            'customer_id'=>$physicalRecord->customer_id,
                        ]   
                       );
                       $physical=$phy->id;

                       $arr=$data['Address'];
                       // dd($arr);
                           foreach ($arr as $key => $value) 
                    {
                       $addressRecord=new Address();
                       $addressRecord->location_name=$value['location_name'];
                       $addressRecord->address_1=$value['address_1'];
                       $addressRecord->address_2=$value['address_2'];
                       $addressRecord->address_3=$value['address_3'];
                       $addressRecord->address_4=$value['address_4'];
                       $addressRecord->latitude=$value['latitude'];
                       $addressRecord->longitude=$value['longitude'];
                       $addressRecord->location_type=$value['location_type'];
                       $addressRecord->site_name=$value['site_name'];
                       $addressRecord->country_id=$value['country_id'];
                       $addressRecord->nearest_landmark=$value['nearest_landmark'];
                       $addressRecord->companylandline_number=$value['companylandline_number'];
                       $addressRecord->postal_code=$value['postal_code'];
                       $addressRecord->payment_mode=$value['payment_mode'];
                       if($value['country_id']!=110){
                        $addressRecord->kenya_cities_id=null;
                        $addressRecord->territory_id=null;
                       }
                       $addressRecord->customer_id=auth()->user()->id;

                        $address=Address::create([
                            
                        'location_name'=>$addressRecord->location_name,
                       'address_1'=>$addressRecord->address_1,
                       'address_2'=>$addressRecord->address_2,
                       'address_3'=>$addressRecord->address_3,
                       'address_4'=>$addressRecord->address_4,
                       'latitude'=>$addressRecord->latitude,
                       'longitude'=>$addressRecord->longitude,
                       'location_type'=>$addressRecord->location_type,
                       'site_name'=>$addressRecord->site_name,
                       'country_id'=>$addressRecord->country_id,
                       'nearest_landmark'=>$addressRecord->nearest_landmark,
                      'companylandline_number'=> $addressRecord->companylandline_number,
                       'postal_code'=>$addressRecord->postal_code,
                       'payment_mode'=>$addressRecord->payment_mode,
                       'kenya_cities_id' =>$addressRecord->kenya_cities_id,
                        'territory_id'=>$addressRecord->territory_id,
                        'customer_id'=>$addressRecord->customer_id,
                        ]);
                    }
 
                        $arr=$data['Bank Information'];
                         $start=0;
                        // dd($arr);
                            foreach ($arr as $key => $value) {
                                $bankRecord=new BankInformations();
                                $bankRecord->bank_id=$value['bank_id'];
                                $bankRecord->bank_account_number=$value['bank_account_number'];
                                $bankRecord->bank_holder_name=$value['bank_holder_name'];
                                $bankRecord->bank_code=$value['bank_code'];
                                $bankRecord->branch_id=$value['branch_id'];
                                $bankRecord->has_banking_facilities=$value['has_banking_facilities'];
                                $bankRecord->banking_facilities_details=$value['banking_facilities_details'];
                                $bankRecord->bank_iban=$value['bank_iban'];
                                $bankRecord->bank_swift=$value['bank_swift'];
                                $bankRecord->country_id=$value['country_id'];
                                $bankRecord->currency_id=$value['currency_id'];
                                $bankRecord->bank_preferred=$value['bank_preferred'];
                                $bankRecord->bank_details=$value['bank_details'];
                                $bankRecord->customer_id=auth()->user()->id;
                                $banks=BankInformations::create([
                                    'bank_id'=>$bankRecord->bank_id,
                                    'bank_account_number'=>$bankRecord->bank_account_number,
                                    'bank_holder_name'=>$bankRecord->bank_holder_name,
                                    'bank_code'=>$bankRecord->bank_code,
                                    'branch_id'=>$bankRecord->branch_id,
                                    'has_banking_facilities'=>$bankRecord->has_banking_facilities,
                                    'banking_facilities_details'=>$bankRecord->banking_facilities_details,
                                    'bank_iban'=>$bankRecord->bank_iban,
                                    'bank_swift'=>$bankRecord->bank_swift,
                                    'country_id'=>$bankRecord->country_id,
                                    'currency_id'=>$bankRecord->currency_id,
                                    'bank_preferred'=>$bankRecord->bank_preferred,
                                    'bank_details'=>$bankRecord->bank_details,
                                    'customer_id'=>$bankRecord->customer_id,
                                ]);
                                if($value['bank_preferred']==1){
                                    $bank=$banks->id;
                                }
                            }

                            $array=$data['Business References'];
                            $start=0;
                            foreach ($array as $key => $value) {
                            $businessRecord=new BusinessReferences();
                            $businessRecord->name_of_company=$value['name_of_company'];
                            $businessRecord->name_of_the_contact_person=$value['name_of_the_contact_person'];
                            $businessRecord->email_address=$value['email_address'];
                            $businessRecord->telephone_number=$value['telephone_number'];
                            $businessRecord->mobile_number=$value['mobile_number'];
                            $businessRecord->company_types_id=$value['company_types_id'];
                            $businessRecord->year_relationship=$value['year_relationship'];
                            $businessRecord->customer_id=auth()->user()->id;
                            $business1=BusinessReferences::create([
                                'name_of_company'=>$businessRecord->name_of_company,
                                'name_of_the_contact_person'=>$businessRecord->name_of_the_contact_person,
                                'email_address'=>$businessRecord->email_address,
                                'telephone_number'=>$businessRecord->telephone_number,
                                'mobile_number'=>$businessRecord->mobile_number,
                                'company_types_id'=>$businessRecord->company_types_id,
                                'year_relationship'=>$businessRecord->year_relationship,
                                'customer_id'=>$businessRecord->customer_id,
                            ]);
                            $business=$business1->id;
                        }
                            $financialRecord=new Financials();
                            $financialRecord->approx_turnover_for_last_year=$data['approx_turnover_for_last_year'];
                            $financialRecord->name_of_auditor=$data['name_of_auditor'];
                            $financialRecord->finance_contact_person=$data['finance_contact_person'];
                            $financialRecord->finance_email_address=$data['finance_email_address'];
                            $financialRecord->finance_telephone_number=$data['finance_telephone_number'];
                            $financialRecord->finance_mobile_number=$data['finance_mobile_number'];
                            $financialRecord->customer_id=auth()->user()->id;
                            $financial=Financials::create([
                                'approx_turnover_for_last_year'=>$financialRecord->approx_turnover_for_last_year,
                                'name_of_auditor'=>$financialRecord->name_of_auditor,
                                'finance_contact_person'=>$financialRecord->finance_contact_person,
                                'finance_email_address'=>$financialRecord->finance_email_address,
                                'finance_telephone_number'=>$financialRecord->finance_telephone_number,
                                'finance_mobile_number'=>$financialRecord->finance_mobile_number,
                                'customer_id'=>$financialRecord->customer_id,
                            ]);
                            $finance=$financial->id;

                            $keyManageRecord=new KeyManagements();
                            $keyManageRecord->ceo_contact_name= $data['ceo_contact_name'];
                            $keyManageRecord->ceo_contact_email_address=$data['ceo_contact_email_address'] ;
                            $keyManageRecord->ceo_contact_phone_number= $data['ceo_contact_phone_number'];
                            $keyManageRecord->cfo_contact_name=$data['cfo_contact_name'] ;
                            $keyManageRecord->cfo_contact_email_address= $data['cfo_contact_email_address'];
                            $keyManageRecord->cfo_contact_phone_number= $data['cfo_contact_phone_number'] ;
                            // $keyManageRecord->owner_contact_email_address= $data['owner_address'] ;
                            $keyManageRecord->owner_contact_name= $data['owner_contact_name'] ;
                            $keyManageRecord->owner_contact_email_address= $data['owner_contact_email_address'] ;
                            $keyManageRecord->owner_contact_phone_number= $data['owner_contact_phone_number'] ;
                            $keyManageRecord->payment_contact_name=$data['payment_contact_name'] ;
                            $keyManageRecord->payment_contact_email_address=$data['payment_contact_email_address'] ;
                            $keyManageRecord->payment_contact_phone_number= $data['payment_contact_phone_number'] ;
                            $keyManageRecord->authorized_contact_name=  $data['authorized_contact_name'] ;
                            $keyManageRecord->authorized_contact_email_address=  $data['authorized_contact_email_address'] ;
                            $keyManageRecord->authorized_contact_phone_number= $data['authorized_contact_phone_number'] ;
                            $keyManageRecord->any_other_remarks= $data['any_other_remarks'] ;
                            $keyManageRecord->customer_id=auth()->user()->id;
                            $KeyManagement=KeyManagements::create([                               
                              'ceo_contact_name' => $keyManageRecord->ceo_contact_name,
                              'ceo_contact_email_address' => $keyManageRecord->ceo_contact_email_address,
                              'ceo_contact_phone_number' => $keyManageRecord->ceo_contact_phone_number,
                              'cfo_contact_name' => $keyManageRecord->cfo_contact_name,
                              'cfo_contact_email_address' => $keyManageRecord->cfo_contact_email_address,
                              'cfo_contact_phone_number' => $keyManageRecord->cfo_contact_phone_number,
                            //   'owner_address' => $keyManageRecord->owner_address,
                              'owner_contact_name' => $keyManageRecord->owner_contact_name,
                              'owner_contact_email_address' => $keyManageRecord->owner_contact_email_address,
                              'owner_contact_phone_number' => $keyManageRecord->owner_contact_phone_number,
                              'payment_contact_name' => $keyManageRecord->payment_contact_name,
                              'payment_contact_email_address' => $keyManageRecord->payment_contact_email_address,
                              'payment_contact_phone_number' => $keyManageRecord->payment_contact_phone_number,
                              'authorized_contact_name' => $keyManageRecord->authorized_contact_name,
                              'authorized_contact_email_address' => $keyManageRecord->authorized_contact_email_address,
                              'authorized_contact_phone_number' => $keyManageRecord->authorized_contact_phone_number,
                              'any_other_remarks' => $keyManageRecord->any_other_remarks,
                              'customer_id'=>$keyManageRecord->customer_id,
                            ]);
                            $keyManage=$KeyManagement->id;


                            $legalRecords=new LegalInformations();
                            $legalRecords->certificate_of_incorporation=$data['certificate_of_incorporation'];
                            $legalRecords->certificate_of_incorporation_issue_date=$data['certificate_of_incorporation_issue_date'];
                            $legalRecords->business_permit_issue_expiry_date=$data['business_permit_issue_expiry_date'];
                            $legalRecords->business_permit_number=$data['business_permit_number'];
                            $legalRecords->pin_number=$data['pin_number'];
                            $legalRecords->years_in_business=$data['years_in_business'];
                            $legalRecords->certificate_of_incorporation_copy=$data['certificate_of_incorporation_copy'];
                            $legalRecords->pin_certificate_copy=$data['pin_certificate_copy'];
                            $legalRecords->business_permit_copy=$data['business_permit_copy'];
                            $legalRecords->cr12_documents=$data['cr12_documents'];
                            $legalRecords->passport_ceo=$data['passport_ceo'];
                            $legalRecords->passport_photo_ceo=$data['passport_photo_ceo'];
                            $legalRecords->statement=$data['statement'];
                            // $legalRecords->tax_compliance_certificate=$data['tax_compliance_certificate'];
                            // $legalRecords->excemption_category=$data['excemption_category'];
                            $legalRecords->customer_id=auth()->user()->id;
                            $legalInfo=LegalInformations::create([
                                'certificate_of_incorporation'=>$legalRecords->certificate_of_incorporation,
                                'certificate_of_incorporation_issue_date'=>$legalRecords->certificate_of_incorporation_issue_date,
                                'business_permit_issue_expiry_date'=>$legalRecords->business_permit_issue_expiry_date,
                                'business_permit_number'=>$legalRecords->business_permit_number,
                                'pin_number'=>$legalRecords->pin_number,
                                'certificate_of_incorporation_copy'=>$legalRecords->certificate_of_incorporation_copy,
                                'years_in_business'=>$legalRecords->years_in_business,
                                'pin_certificate_copy'=>$legalRecords->pin_certificate_copy,
                                'business_permit_copy'=>$legalRecords->business_permit_copy,
                                'cr12_documents'=>$legalRecords->cr12_documents,
                                'passport_photo_ceo'=>$legalRecords->passport_photo_ceo,
                                'passport_ceo'=>$legalRecords->passport_ceo,
                                'statement'=> $legalRecords->statement,
                                // 'tax_compliance_certificate'=>$legalRecords->tax_compliance_certificate,
                                // 'excemption_category'=>$legalRecords->excemption_category,
                                'customer_id'=>$legalRecords->customer_id
                            ]);
                            $legal=$legalInfo->id;


                            // $otherDocumentsRecord[]=new OtherDocuments();
                            $array=$data['Other Documents'];
                            // dd($arr);
                            // $s=0;
                                foreach ($array as $key => $value) {
                                    // code to be executed for each element
                                    // $loc=$value['lat'];
                                    $otherDocument=new OtherDocuments();
                                    $otherDocument->document_types_id=$value['document_types_id'];
                                    $otherDocument->document=$value['document'];
                                    // $otherDocument-> document_path=$value->path();
                                    $otherDocument->description=$value['description'];
                                    $otherDocument->customer_id=auth()->user()->id;

                                    $otherDoc=OtherDocuments::create([
                                        'document_types_id'=>$otherDocument->document_types_id,
                                        'document_name'=>$otherDocument->document_name,
                                        'document'=>$otherDocument->document,
                                        'document_path'=>$otherDocument->document_path,
                                        'description'=>$otherDocument->description,
                                        'customer_id'=>$otherDocument->customer_id,
                                    ]);
                                    $other=$otherDoc->id;
                                    // dd($otherDocument);
                                    // $otherDocumentsRecord[$s]=$otherDocument;
                                    // $s++;
                                }
                                // $data= new CustomerSites();
                                $data['bank_informations_id']=$bank;
                                $data['financials_id']=$finance;
                                $data['physical_informations_id']=$physical;
                                $data['business_references_id']=$business;
                                $data['key_managements_id']=$keyManage;
                                $data['legal_informations_id']=$legal;
                                $data['other_documents_id']=$other;
                                $data['documents_id']=$document;
                                $data['address_id']=$address->id;
                                $data['customer_id']=auth()->user()->id;

                                $this->email = $this->data['email'];
        // $this->name=customer::query()->where('email',$this->email)->value('name');
        // $this->notify(new ApplicationSubmit($this->name));
        //                 Notification::make()
        //                 ->title(__('filament-otp-login::translations.notifications.title'))
        //                 ->body(__('filament-otp-login::translations.notifications.body'))
        //                 ->success()
        //                 ->send();
                                return $data;
    }

    public function mutateFormDataAfterSave(array $data)
    {
        
        CustomerSites::create($data);
     
    } 

}
