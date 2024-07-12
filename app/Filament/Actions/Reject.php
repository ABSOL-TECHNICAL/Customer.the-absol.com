<?php

namespace App\Filament\Actions;

use App\Enums\ApplicationStatus;
use App\Enums\ApprovelStatus;
use App\Filament\Notifications\RejectForm;
use App\Models\ApprovalStatus;
use App\Models\ProcessApprovalFlow;
use App\Models\Role;
use App\Models\Customer;
use App\Models\CustomerSites;
use App\Models\User;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Illuminate\Support\Arr;
use  App\Notifications\CustomerNotification;

class Reject extends Action
{

    public static function getDefaultName(): ?string
    {
        return 'Reject';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('danger')
            ->action($this->reject())
            ->label('Reject')
            ->icon('heroicon-m-no-symbol')
            ->form($this->getDefaultForm())
            ->visible(fn (Model $record) => true)
            ->requiresConfirmation()
            ->modalDescription('Are you sure you want to reject this application?');
    }

    private function reject(): \Closure
    {
        return function (array $data, Model $record): bool {
             $customerSite=CustomerSites::find($record->id);
            $comment = $data["comment"] ?? '';
            $user = Customer::find($record->customer_id); 
            
            if($record->approval_flow==ProcessApprovalFlow::query()->pluck('order')->first()){
                
            $user->notify(new CustomerNotification($record, $comment, $customerSite));
                $record->status=ApplicationStatus::REJECTED;
                $record->update();
                $approvalStatus=ApprovalStatus::query()->where('user_id',auth()->user()->id)->where('customer_sites_id',$record->id)->where('status','processing')->first();

                if($approvalStatus==null){
                    $approvalStatus=ApprovalStatus::create(['customer_sites_id'=>$record->id,'user_id'=>auth()->user()->id,'comment'=>Arr::get($data, 'comment', ''),'status'=> ApprovelStatus::REJECTED]);
                    
    
                }
                else{
                    $approvalStatus->status=ApprovelStatus::REJECTED;
                    $approvalStatus->comment=Arr::get($data, 'comment','');
                    $approvalStatus->update();
                }
            }

            else{
                $user->notify(new CustomerNotification($record, $comment, $customerSite));
                $record->approval_flow=ProcessApprovalFlow::query()->pluck('order')->first();
                $record->update();
                
                $status=ApprovalStatus::query()->where('user_id',auth()->user()->id)->where('customer_sites_id',$record->id)->where('status','processing')->first();
                $status->status=ApprovelStatus::REJECTED;
                $status->comment=Arr::get($data, 'comment','');
                $status->update();
                
                $id=ProcessApprovalFlow::query()->pluck('id')->min();
                $roleId=ProcessApprovalFlow::query()->where('id',$id)->pluck('role_id')->first();
                $previousApprover= User::role($roleId)->pluck('id')->toArray();

                foreach($previousApprover as $key=>$value){
                    ApprovalStatus::create(['customer_sites_id'=>$record->id,'user_id'=>$value,'status'=> ApprovelStatus::PROCESSING,]);
                }

                
            }

            //Email-Trigger
            $currentRoleId = auth()->user()->roles->first()->id;
            $currentApproverEmail = auth()->user()->email;
            $orderId = ProcessApprovalFlow::query()->where('role_id', $currentRoleId)->value('order');
            $nextApprovers = ProcessApprovalFlow::where('order', '<', $orderId)->pluck('role_id')->toArray();

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

            $currentApprover = new User();
            $currentApprover->email = $currentApproverEmail;

            $comment = $data["comment"] ?? '';

            // Notify the current approver with or without cc emails
            $currentApprover->notify(new RejectForm($ccEmails, $comment));

            Notification::make()
                ->title('Rejected successfully')
                ->success()
                ->send();

            return true;
        };
    }

    protected function getDefaultForm(): array
    {
        return [
            Textarea::make("comment")
            ->required(),
        ];
    }
}
