<?php

namespace App\Filament\Actions;

use App\Enums\ApplicationStatus;
use App\Enums\ApprovelStatus;
use App\Filament\Notifications\ApproveDocuments;
use App\Helpers\VendorApi;
use App\Models\AccountType;
use App\Models\ApprovalAnswers;
use App\Models\ApprovalComment;
use App\Models\ApprovalStatus;
use App\Models\BusinessReferences;
use App\Models\Collector;
use App\Models\CustomerCategories;
use App\Models\FreightTerms;
use App\Models\OrderType;
use App\Models\PaymentTerms;
use App\Models\PriceList;
use App\Models\ProcessApprovalFlow;
use App\Models\Role;
use App\Models\Customer;
use App\Models\CustomerSites;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Filament\Forms\Components\TextInput;
use App\Jobs\CreateCustomerJob;
use App\Models\Address;
use App\Models\SalesRepresentative;
use App\Models\SalesTerritory;

class Approve extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'Approve';
    }


    protected function setUp(): void
    {
        parent::setUp();

        $this->color('success')
            ->action($this->approve())
            ->icon('heroicon-m-check')
            ->label('Approve')
            ->form($this->getDefaultForm())
            ->visible(fn (Model $record) => true)
            ->requiresConfirmation()
            ->modalWidth('xl')
            ->modalDescription('Are you sure you want to approve this application?');
    }


    /**
     * Approve data function.
     *
     */
    private function approve(): \Closure
    {
        return function (array $data, Model $record): bool {
            // dd($record);
            if ($record->approval_flow == ProcessApprovalFlow::query()->pluck('order')->last()) {

                $record->approval_flow = $record->approval_flow + 1;
                $record->status = ApplicationStatus::APPROVED;
                $record->update();

                $approvalStatus = ApprovalStatus::query()->where('user_id', auth()->user()->id)->where('customer_sites_id', $record->id)->where('status', 'processing')->first();
                $approvalStatus->status = ApprovelStatus::APPROVED;
                $approvalStatus->comment = Arr::get($data, 'comment', '');
                $approvalStatus->update();

                $job = new CreateCustomerJob($record);
                dispatch_sync($job);
 
                if ($job->success) {
                    Notification::make()
                        ->title('Oracle sync failed ')
                        ->danger()
                        ->send();
                    $record->update();
                } else {
                    Notification::make()
                        ->title('Oracle synced successfully')
                        ->success()
                        ->send();
                        // $record->customer_oracle_sync_site = 1;
                        $record->update();
    
                        $address=Address::query()->where('customer_id', $record->customer_id)->get()->toArray();
                        foreach($address as $key=>$value) {
                            $rec=Address::find($value['id']);
                            $rec->customer_site_synced=1;
                            $rec->update();
                        }
                }
            } else if ($record->approval_flow == ProcessApprovalFlow::query()->pluck('order')->first()) {
                $ans=ApprovalAnswers::query()->where('customer_sites_id',$record->id)->get()->count();
                $business=BusinessReferences::query()->where('customer_id',$record->customer_id)->get()->count();
                $count=$business-$ans;
                if($ans!=$business){
                    Notification::make()
                    ->title('Approve Not Allowed')
                    ->body("Without verify ".$count." Questionnaire You are not Allow")
                    ->warning()
                    ->send();
                    return false;
                }
                $record->approval_flow = $record->approval_flow + 1;
                $record->update();


                $approvalStatus = ApprovalStatus::query()->where('user_id', auth()->user()->id)->where('customer_sites_id', $record->id)->where('status', 'processing')->first();

                if ($approvalStatus == null) {
                    $approvalStatus = ApprovalStatus::create(['customer_sites_id' => $record->id, 'user_id' => auth()->user()->id,'comment' => Arr::get($data, 'comment', ''), 'status' => ApprovelStatus::APPROVED]);
                } else {
                    $approvalStatus->status = ApprovelStatus::APPROVED;
                    $approvalStatus->comment = Arr::get($data, 'comment', '');
                    $approvalStatus->update();
                }



                $roleId = auth()->user()->roles->first()->id;
                $flowOrderId = ProcessApprovalFlow::query()->where('role_id', $roleId)->value('order');
                $nextRoleId = ProcessApprovalFlow::where('order', '>', $flowOrderId)->value('role_id');
                $nextApprover = User::role($nextRoleId)->pluck('id')->toArray();

                foreach ($nextApprover as $key => $value) {
                    ApprovalStatus::create(['customer_sites_id' => $record->id, 'user_id' => $value, 'status' => ApprovelStatus::PROCESSING]);
                }

            } 
            else if($record->approval_flow == ProcessApprovalFlow::query()->pluck('order')->first()+1){

                $record->approval_flow = $record->approval_flow + 1;
                $record->update();

                $approvalStatus = ApprovalStatus::query()->where('user_id', auth()->user()->id)->where('customer_sites_id', $record->id)->where('status', 'processing')->first();
                $approvalStatus->status = ApprovelStatus::APPROVED;
                $approvalStatus->comment = Arr::get($data, 'comment', '');
                $approvalStatus->update();
                ApprovalComment::create(['approval_status_id'=>$approvalStatus->id,
                    'user_id'=>auth()->user()->id,
                    'customer_sites_id'=>$record->id,
                    'comment'=>Arr::get($data, 'comment', ''),
                    'request_credit_value' => Arr::get($data, 'request_credit_value', ''),
                    'approved_credit_value' => Arr::get($data, 'approved_credit_value', ''),
                    'payment_terms_id' => Arr::get($data, 'payment_terms_id', ''),
                    'freight_terms_id' => Arr::get($data, 'freight_terms_id', ''),
                    'account_type_id' => Arr::get($data, 'account_type_id', ''),
                    'sales_territory_id' => Arr::get($data, 'sales_territory_id', ''),
                    'sales_representative_id' => Arr::get($data, 'sales_representative_id', ''),
                    'collector_id' => Arr::get($data, 'collector_id', ''),
                    'price_list_id' => Arr::get($data, 'price_list_id', ''),
                    'order_type_id' => Arr::get($data, 'order_type_id', ''),
                    'customer_categories_id' => Arr::get($data, 'customer_categories_id', ''),
                    'address_id'=>$record->address_id,
                    ]);

                $roleId = auth()->user()->roles->first()->id;
                $flowOrderId = ProcessApprovalFlow::query()->where('role_id', $roleId)->value('order');
                $nextRoleId = ProcessApprovalFlow::where('order', '>', $flowOrderId)->value('role_id');
                $nextApprover = User::role($nextRoleId)->pluck('id')->toArray();

                foreach ($nextApprover as $key => $value) {
                    ApprovalStatus::create(['customer_sites_id' => $record->id, 'user_id' => $value, 'status' => ApprovelStatus::PROCESSING]);
                }
            }
            else {

                $record->approval_flow = $record->approval_flow + 1;
                $record->update();

                $approvalStatus = ApprovalStatus::query()->where('user_id', auth()->user()->id)->where('customer_sites_id', $record->id)->where('status', 'processing')->first();
                $approvalStatus->status = ApprovelStatus::APPROVED;
                $approvalStatus->comment = Arr::get($data, 'comment', '');
                $approvalStatus->update();

                $roleId = auth()->user()->roles->first()->id;
                $flowOrderId = ProcessApprovalFlow::query()->where('role_id', $roleId)->value('order');
                $nextRoleId = ProcessApprovalFlow::where('order', '>', $flowOrderId)->value('role_id');
                $nextApprover = User::role($nextRoleId)->pluck('id')->toArray();

                foreach ($nextApprover as $key => $value) {
                    ApprovalStatus::create(['customer_sites_id' => $record->id, 'user_id' => $value, 'status' => ApprovelStatus::PROCESSING]);
                }
            }

            $currentRoleId = auth()->user()->roles->first()->id;
            $currentApproverEmail = auth()->user()->email;
            $orderId = ProcessApprovalFlow::query()->where('role_id', $currentRoleId)->value('order');
            $nextApprovers = ProcessApprovalFlow::where('order', '>', $orderId)->pluck('role_id')->toArray();

            $ccEmails = [];
            if (!empty($nextApprovers)) {
                foreach ($nextApprovers as $nextRoleId) {
                    $roleName = Role::query()->where('id', $nextRoleId)->value('name');
                    $emails = User::role($roleName)->pluck('email')->toArray();
                    $ccEmails = array_merge($ccEmails, $emails);
                }
            } else {

                $customerEmail = Customer::query()->where('id',$record->customer_id)->value('email');
                if ( $customerEmail) {
                    $ccEmails[] =  $customerEmail;
                } 
            }

            // Create a new User instance for the current approver
            $currentApprover = new User();
            $currentApprover->email = $currentApproverEmail;

            // Notify the current approver with or without cc emails
            $currentApprover->notify(new ApproveDocuments($ccEmails));

            Notification::make()
                ->title('Approved successfully')
                ->success()
                ->send();
            return true;
        };
    }
    protected function getDefaultForm(): array
    {
        return [
            TextInput::make('request_credit_value')->label('Request Credit Value')->default('0')->required()->readOnly()
                ->visible(function (Model $record) {
                    if ($record->approval_flow == ProcessApprovalFlow::query()->pluck('order')->first() + 1) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            TextInput::make('approved_credit_value')->label('Approved Credit Value')->numeric()->required()
                ->visible(function (Model $record) {
                    if ($record->approval_flow == ProcessApprovalFlow::query()->pluck('order')->first() + 1) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            Select::make("payment_terms_id")
                ->label('Credit Payment')
                ->required()
                ->visible(function (Model $record) {
                    if ($record->approval_flow == ProcessApprovalFlow::query()->pluck('order')->first() + 1) {
                        return true;
                    } else {
                        return false;
                    }
                })
                ->options(fn (Get $get): Collection => PaymentTerms::query()
                ->pluck('payment_term_name', 'id')),
            Select::make("account_type_id")
                ->label('Customer Type')
                ->required()
                ->visible(function (Model $record) {
                    if ($record->approval_flow == ProcessApprovalFlow::query()->pluck('order')->first() + 1) {
                        return true;
                    } else {
                        return false;
                    }
                })
                ->options(fn (Get $get): Collection => AccountType::query()
                ->pluck('type', 'id')),
            Select::make("freight_terms_id")
                ->label('Customer Freight Terms')
                ->required()
                ->visible(function (Model $record) {
                    if ($record->approval_flow == ProcessApprovalFlow::query()->pluck('order')->first() + 1) {
                        return true;
                    } else {
                        return false;
                    }
                })
                ->options(fn (Get $get): Collection => FreightTerms::query()
                ->pluck('name', 'id')),
            Select::make('sales_territory_id')
                    ->label('Sales Territory')
                    ->required()
                    ->visible(function(Model $record){
                        if($record->approval_flow==ProcessApprovalFlow::query()->pluck('order')->first()+1){
                        return true;
                        }
                        else{
                        return false;
                        }
                    })
                    ->options(fn(Get $get):Collection=>SalesTerritory::query()
                            ->pluck('sales_territory','id')),   
            Select::make('sales_representative_id')
                            ->label('Sales Representative')
                            ->required()
                            ->visible(function(Model $record){
                                if($record->approval_flow==ProcessApprovalFlow::query()->pluck('order')->first()+1){
                                return true;
                                }
                                else{
                                return false;
                                }
                            })
                            ->options(fn(Get $get):Collection=>SalesRepresentative::query()
                                    ->pluck('sales_representative','id')),              
            Select::make('collector_id')
                            ->label('Collector')
                            ->required()
                            ->visible(function(Model $record){
                                        if($record->approval_flow==ProcessApprovalFlow::query()->pluck('order')->first()+1){
                                        return true;
                                        }
                                        else{
                                        return false;
                                        }
                                    })
                            ->options(fn(Get $get):Collection=>Collector::query()
                                            ->pluck('collector_name','id')),  

            Select::make('price_list_id')
                                            ->label('Price List')
                                            ->required()
                                            ->visible(function(Model $record){
                                                if($record->approval_flow==ProcessApprovalFlow::query()->pluck('order')->first()+1){
                                                return true;
                                                }
                                                else{
                                                return false;
                                                }
                                            })
                                            ->options(fn(Get $get):Collection=>PriceList::query()
                                                    ->pluck('Price_list_name','id')),              
            Select::make('order_type_id')
                                            ->label('Order Type')
                                            ->required()
                                            ->visible(function(Model $record){
                                                        if($record->approval_flow==ProcessApprovalFlow::query()->pluck('order')->first()+1){
                                                        return true;
                                                        }
                                                        else{
                                                        return false;
                                                        }
                                                    })
                                            ->options(fn(Get $get):Collection=>OrderType::query()
                                                            ->pluck('order_type','id')),  


            Select::make("customer_categories_id")
                ->label('Customer Class')
                ->required()
                ->visible(function (Model $record) {
                    if ($record->approval_flow == ProcessApprovalFlow::query()->pluck('order')->first() + 1) {
                        return true;
                    } else {
                        return false;
                    }
                })
                ->options(fn (Get $get): Collection => CustomerCategories::query()
                ->pluck('customer_categories_name', 'id')),
            Textarea::make("comment")
                ->required()
                ->label('Comments'),
               
        ];
    }
}
