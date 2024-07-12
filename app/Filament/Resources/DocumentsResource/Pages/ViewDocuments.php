<?php

namespace App\Filament\Resources\DocumentsResource\Pages;

use App\Filament\Resources\DocumentsResource;
use App\Models\Bank;
use App\Models\BankInformations;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Currency;
use App\Models\LegalInformations;
use App\Models\OtherDocuments;
use App\Models\PhysicalInformations;
use Filament\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewDocuments extends ViewRecord
{
    protected static string $resource = DocumentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
    public function getRelationManagers(): array
    {
        return [
            // 
           
        ];
   }
   protected function getViewData(): array
   {
       $additionalData = $this->getRecord();
       $physicalRecord = PhysicalInformations::find($additionalData->physical_informations_id);
       $legal = LegalInformations::find($additionalData->legal_informations_id);
       $bank = BankInformations::query()->where('customer_id',$additionalData->customer_id)->get()->toArray();
       $other = OtherDocuments::query()->where('customer_id',$additionalData->customer_id)->get()->toArray();
      
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
        $this->record['Bank Information'] = $bankInformations;

      $this->record['Other Documents'] = $other ;
       
       return  array_merge(parent::getViewData());
   }
 
   public  function infolist(Infolist $infolist): Infolist
   {

       $physical = PhysicalInformations::find($this->getRecord()->physical_informations_id);
       return $infolist
           // ------------------------------------------------Physical Info--------------------------------------------------------------
           ->schema([
              
                       // -------------------------------------------Legal Information---------------------------------------------------------

                       Section::make('Legal Information')
                       ->schema([
                           TextEntry::make('certificate_of_incorporation_copy')
                               ->suffixActions([
                                   Action::make('Download')
                                       ->icon('heroicon-o-folder-arrow-down')
                                       ->url(function (Model $record) {
                                           $file = $record->certificate_of_incorporation_copy;
                                           // dd($file);
                                           return route('download', $file);
                                       })
                                       ->button()
                               ]),
                           TextEntry::make('pin_certificate_copy')
                               ->suffixActions([
                                   Action::make('Download')
                                       ->icon('heroicon-o-folder-arrow-down')
                                       ->url(function (Model $record) {
                                           $file = $record->pin_certificate_copy;
                                           // dd($file);
                                           return route('download', $file);
                                       })
                                       ->button()
                               ]),
                           TextEntry::make('business_permit_copy')->label('Business Permit Copy')
                               ->suffixActions([
                                   Action::make('Download')
                                       ->icon('heroicon-o-folder-arrow-down')
                                       ->url(function (Model $record) {
                                           $file = $record->business_permit_copy;
                                           // dd($file);
                                           return route('download', $file);
                                       })
                                       ->button()
                               ]),
                           TextEntry::make('cr12_documents')->label('CR12 Document')
                               ->suffixActions([
                                   Action::make('Download')
                                       ->icon('heroicon-o-folder-arrow-down')
                                       ->url(function (Model $record) {
                                           $file = $record->cr12_documents;
                                           // dd($file);
                                           return route('download', $file);
                                       })
                                       ->button()
                               ]),
                           TextEntry::make('passport_ceo')->label('Passport/National ID of Director/CEO')
                               ->suffixActions([
                                   Action::make('Download')
                                       ->icon('heroicon-o-folder-arrow-down')
                                       ->url(function (Model $record) {
                                           $file = $record->passport_ceo;
                                           // dd($file);
                                           return route('download', $file);
                                       })
                                       ->button()
                               ]),
                           TextEntry::make('passport_photo_ceo')->label('Passport size Photo of Director/ CEO ')
                               ->suffixActions([
                                   Action::make('Download')
                                       ->icon('heroicon-o-folder-arrow-down')
                                       ->url(function (Model $record) {
                                           $file = $record->passport_photo_ceo;
                                           // dd($file);
                                           return route('download', $file);
                                       })
                                       ->button()
                               ]), TextEntry::make('statement')->label('Bank Statement')
                               ->suffixActions([
                                   Action::make('Download')
                                       ->icon('heroicon-o-folder-arrow-down')
                                       ->url(function (Model $record) {
                                           $file = $record->statement;
                                           // dd($file);
                                           return route('download', $file);
                                       })
                                       ->button()
                               ]),
                       ])->columns(2),
                       Section::make('CUSTOMER BANK STATEMENT')
                       ->schema([
                           RepeatableEntry::make('Bank Information')->label('Customer Bank Statement Details')
                               ->schema([
                                TextEntry::make('bank_details')->label('Bank Details')
                                ->suffixActions([
                                    Action::make('Download')
                                        ->icon('heroicon-o-folder-arrow-down')
                                        ->url(function (Model $record) {
                                            $bank = $record['Bank Information'];
                                            foreach ($bank as $key => $value) {
                                                $file = $value['bank_details'];
                                                // dd($file);
                                                return route('download', $file);
                                            }
                                        })
                                        ->button()
                            
                                   ]),
                               ])->columns(3)
                       ]),
   
               

                   // ------------------------------------------------------Other Documents-------------------------------------------------
                   Section::make('Other Documents')
                   ->schema([
                  RepeatableEntry::make('Other Documents')
                           ->schema([
                               TextEntry::make('document')
                                   ->label('Document')
                                   ->suffixActions([
                                       Action::make('Download')
                                           ->icon('heroicon-o-folder-arrow-down')
                                           ->url(function(Model $record){
                                               $otherDocs= $record['Other Documents'];

                                               foreach($otherDocs as $key => $value){
                                                   $file=$value['document'];
                                                   return route('download', $file);
                                               }
                                           })
                                           ->button()
                                   ]),
                               // TextEntry::make('description')
                               //     ->label('Description'),
                               ]),
                     ])->columns(2),
                        ]);
                   
           
           }
}
