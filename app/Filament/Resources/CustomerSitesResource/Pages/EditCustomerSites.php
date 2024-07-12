<?php

namespace App\Filament\Resources\CustomerSitesResource\Pages;

use App\Filament\Resources\CustomerSitesResource;
use App\Filament\Actions\ReSubmitAction;
use App\Filament\Actions\SubmitAction;
use App\Filament\Resources\CustomerDetailsResource\Pages\RelationManagers\LegalInformationsRelationsManager;
use App\Filament\Resources\CustomerDetailsResource\Pages\RelationManagers\OtherDocumentsRelationsManager;
use App\Filament\CustomerResources\CustomerSitesResource\Pages;
use App\Filament\CustomerResources\CustomerSitesResource\RelationManagers;
use App\Models\Address;
use Filament\Resources\Pages\EditRecord;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\BusinessReferences;
use App\Models\CompanyTypes;
use App\Models\Country;
use App\Models\Currency;
use App\Models\DocumentTypes;
use App\Models\PhysicalInformations;
use App\Models\CustomerSites;
use App\Models\Financials;
use App\Models\KeyManagements;
use App\Models\LegalInformations;
use App\Models\OtherDocuments;
use Carbon\Carbon;
use Filament\Actions\Concerns\HasForm;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\HtmlString;
use Traineratwot\FilamentOpenStreetMap\Forms\Components\MapInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\DatePicker;
use Exception;
use Filament\Forms\Components;
use Filament\Notifications\Notification;
use App\Rules\OnePreferredBank;
 

class EditCustomerSites extends EditRecord
{
    protected static string $resource = CustomerSitesResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    public function getFormActions(): array
    {
        return [
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
        ];
    }
    public  function form(Form $form): Form
    {

        $site = $this->getRecord();
        // dd($site);
        if ($site->update_type == 0) {
            return CustomerSitesResource::form($form);
        }
        else{
            return CustomerSitesResource::addressForm($form);
        }
        
    }
    protected  function getDefaultCountryId()
    {
        $defaultCountry = Country::where('country_name', 'Kenya')->first();
        return $defaultCountry ? $defaultCountry->id : null;
    }
    protected function fillForm(): void
    {


        $additionalData = $this->getRecord();
        $physicalRecord=PhysicalInformations::find( $additionalData ->physical_informations_id);
        // $bank = BankInformations::query()->where('customer_id',$additionalData->customer_id)->get()->toArray();
        
            $addressRecord = Address::where('id',$additionalData->address_id)->get()->toArray();
        
    
        $business = BusinessReferences::query()->where('customer_id', $additionalData->customer_id)->get()->toArray();
        $finance=Financials::find( $additionalData ->financials_id);
        $keyManage=KeyManagements::find( $additionalData ->key_managements_id);
        $legal=LegalInformations::find( $additionalData ->legal_informations_id);
        $other = OtherDocuments::query()->where('customer_id',$additionalData->customer_id)->get()->toArray();        // dd($business);
             
                $this->record['name']=$physicalRecord->name;
                $this->record['email']= $physicalRecord->email;
                $this->record['name_of_the_company']=$physicalRecord->name_of_the_company;
                $this->record['group_company_of']=$physicalRecord->group_company_of;
                $this->record['website']=$physicalRecord->website;


               
                $this->record['Address'] = $addressRecord;

                // $this->record['Bank Information']=$bank;



                $this->record['Business References']=$business;

                $this->record['approx_turnover_for_last_year']=$finance->approx_turnover_for_last_year;
                $this->record['name_of_auditor']=$finance->name_of_auditor;
                $this->record['finance_contact_person']=$finance->finance_contact_person;
                $this->record['finance_email_address']=$finance->finance_email_address;
                $this->record['finance_telephone_number']=$finance->finance_telephone_number;
                $this->record['finance_mobile_number']=$finance->finance_mobile_number;

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

                $this->record['certificate_of_incorporation']=$legal->certificate_of_incorporation;
                $this->record['certificate_of_incorporation_issue_date']=$legal->certificate_of_incorporation_issue_date;
                $this->record['business_permit_issue_expiry_date']=$legal->business_permit_issue_expiry_date;
                $this->record['business_permit_number']=$legal->business_permit_number;
                $this->record['pin_number']=$legal->pin_number;
                $this->record['certificate_of_incorporation_copy']=$legal->certificate_of_incorporation_copy;
                $this->record['years_in_business']=$legal->years_in_business;
                $this->record['pin_certificate_copy']=$legal->pin_certificate_copy;
                $this->record['business_permit_copy']=$legal->business_permit_copy;
                $this->record['cr12_documents']=$legal->cr12_documents;
                $this->record['passport_ceo']=$legal->passport_ceo;
                $this->record['passport_photo_ceo']=$legal->passport_photo_ceo;
                $this->record['statement']=$legal->statement;
               
                $this->record['Other Documents']=$other;
        $this->fillFormWithDataAndCallHooks($this->getRecord());
    }
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if($record->update_type==0)
        {
            $physicalRecord=PhysicalInformations::find($record->physical_informations_id);
                        $physicalRecord->name=$data['name'];
                        $physicalRecord->email=$data['email'];
                        $physicalRecord->name_of_the_company=$data['name_of_the_company'];
                        $physicalRecord->group_company_of=$data['group_company_of'];
                        $physicalRecord->website=$data['website'];
                        $physicalRecord->customer_id=$record->customer_id;
                        $physicalRecord->update();

                        $add=$data['Address'];
                        foreach($add as $key=>$value){
                            if (array_key_exists('id', $value)) 
                            {
                                $addressRecord=Address::find($value['id']);
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
                                   else{
                                       $addressRecord->kenya_cities_id=$value['kenya_cities_id'];
                                    $addressRecord->territory_id=$value['territory_id'];
                                   }
                                $addressRecord->customer_id=$value['customer_id'];
                                $addressRecord->update();
                            }
                            else{
                                if($value['country_id']!=110){
                                    $value['kenya_cities_id']=null;
                                   $value['territory_id']=null;
                                   }
                                Address::create([
                                    'location_name'=>$value['location_name'],
                                   'address_1'=>$value['address_1'],
                                   'address_2'=>$value['address_2'],
                                   'address_3'=>$value['address_3'],
                                   'address_4'=>$value['address_4'],
                                   'latitude'=>$value['latitude'],
                                   'longitude'=>$value['longitude'],
                                   'location_type'=>$value['location_type'],
                                   'site_name'=>$value['site_name'],
                                   'country_id'=>$value['country_id'],
                                   'nearest_landmark'=>$value['nearest_landmark'],
                                  'companylandline_number'=> $value['companylandline_number'],
                                   'postal_code'=>$value['postal_code'],
                                   'payment_mode'=>$value['payment_mode'],
                                   'kenya_cities_id' => $value['kenya_cities_id'],
                                   'territory_id'=> $value['territory_id'],
                                    'customer_id'=>auth()->user()->id,
                                    ]);
                            }
                        }

                        

                        $array=$data['Business References'];
                        foreach ($array as $key => $value) {
                            if (array_key_exists('id', $value)) {
                                $businessRecord=BusinessReferences::find($value['id']);
                                $businessRecord->name_of_company=$value['name_of_company'];
                                $businessRecord->name_of_the_contact_person=$value['name_of_the_contact_person'];
                                $businessRecord->email_address=$value['email_address'];
                                $businessRecord->telephone_number=$value['telephone_number'];
                                $businessRecord->mobile_number=$value['mobile_number'];
                                $businessRecord->company_types_id=$value['company_types_id'];
                                $businessRecord->year_relationship=$value['year_relationship'];
                                $businessRecord->customer_id=$value['customer_id'];
                                $businessRecord->update();
                            }
                            else{
                                $business1=BusinessReferences::create([
                                    'name_of_company'=>$value['name_of_company'],
                                    'name_of_the_contact_person'=>$value['name_of_the_contact_person'],
                                    'email_address'=>$value['email_address'],
                                    'telephone_number'=>$value['telephone_number'],
                                    'mobile_number'=>$value['mobile_number'],
                                    'company_types_id'=>$value['company_types_id'],
                                    'year_relationship'=>$value['year_relationship'],
                                    'customer_id'=>$record->customer_id,
                                ]);
                            }
                        
                    }

                            $financialRecord=Financials::find($record->financials_id);
                            $financialRecord->approx_turnover_for_last_year=$data['approx_turnover_for_last_year'];
                            $financialRecord->name_of_auditor=$data['name_of_auditor'];
                            $financialRecord->finance_contact_person=$data['finance_contact_person'];
                            $financialRecord->finance_email_address=$data['finance_email_address'];
                            $financialRecord->finance_telephone_number=$data['finance_telephone_number'];
                            $financialRecord->finance_mobile_number=$data['finance_mobile_number'];
                            $financialRecord->customer_id=$record->customer_id;
                            $financialRecord->update();


                            $keyManageRecord=KeyManagements::find($record->key_managements_id);
                            $keyManageRecord->owner_contact_name= $data['owner_contact_name'] ;
                            $keyManageRecord->owner_contact_email_address= $data['owner_contact_email_address'] ;
                            $keyManageRecord->owner_contact_phone_number= $data['owner_contact_phone_number'] ;
                            $keyManageRecord->ceo_contact_name= $data['ceo_contact_name'];
                            $keyManageRecord->ceo_contact_email_address=$data['ceo_contact_email_address'] ;
                            $keyManageRecord->ceo_contact_phone_number= $data['ceo_contact_phone_number'];
                            $keyManageRecord->cfo_contact_name=$data['cfo_contact_name'] ;
                            $keyManageRecord->cfo_contact_email_address= $data['cfo_contact_email_address'];
                            $keyManageRecord->cfo_contact_phone_number= $data['cfo_contact_phone_number'] ;
                            // $keyManageRecord->owner_contact_email_address= $data['owner_address'] ;

                            $keyManageRecord->payment_contact_name=$data['payment_contact_name'] ;
                            $keyManageRecord->payment_contact_email_address=$data['payment_contact_email_address'] ;
                            $keyManageRecord->payment_contact_phone_number= $data['payment_contact_phone_number'] ;
                            $keyManageRecord->authorized_contact_name=  $data['authorized_contact_name'] ;
                            $keyManageRecord->authorized_contact_email_address=  $data['authorized_contact_email_address'] ;
                            $keyManageRecord->authorized_contact_phone_number= $data['authorized_contact_phone_number'] ;
                            $keyManageRecord->any_other_remarks= $data['any_other_remarks'] ;
                            $keyManageRecord->customer_id=$record->customer_id;
                            $keyManageRecord->update();


                            $legalRecords=LegalInformations::find($record->legal_informations_id);
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
                            $legalRecords->customer_id=$record->customer_id;
                            $legalRecords->update();


                            $array=$data['Other Documents'];
                            foreach ($array as $key => $value) {
                                if (array_key_exists('id', $value)) 
                                {
                                    $otherDocument=OtherDocuments::find($value['id']);
                                    $otherDocument->document_types_id=$value['document_types_id'];
                                    $otherDocument->document=$value['document'];
                                    $otherDocument->description=$value['description'];
                                    $otherDocument->customer_id=$value['customer_id'];
                                    $otherDocument->update();
                                }
                                else
                                {
                                        OtherDocuments::create([
                                        'document_types_id'=>$value['document_types_id'],
                                        'document'=>$value['document'],
                                        'description'=>$value['description'],
                                        'customer_id'=>$record->customer_id,
                                        ]);
                                }
                            }
                                
        $record->update($data);

        return $record;
        }
        else
        {
            $add=$data['Address'];
            foreach($add as $key=>$value){
                if (array_key_exists('id', $value)) 
                {
                    $addressRecord=Address::find($value['id']);
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
                       else{
                           $addressRecord->kenya_cities_id=$value['kenya_cities_id'];
                        $addressRecord->territory_id=$value['territory_id'];
                       }
                    $addressRecord->customer_id=$value['customer_id'];
                    $addressRecord->update();
                }
            }
            $record->update($data);

        return $record;
        }

                        
    }
}
