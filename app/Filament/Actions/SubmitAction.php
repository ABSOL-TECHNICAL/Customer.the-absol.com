<?php

namespace App\Filament\Actions;

use App\Models\CustomerSites;
use App\Enums\ApplicationStatus;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class SubmitAction extends Action
{

    public static function getDefaultName(): ?string
    {
        return 'Submit';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('success')
            ->action($this->_submit())
            ->icon('heroicon-m-check')
            ->label('Submit')
            ->visible(function (CustomerSites $site) {
                return $this->canShowAction($site);
            })
            ->requiresConfirmation()
            ->modalDescription('Are you sure you want to submit your application?')
            ->extraAttributes(['class' => 'rounded-full py-2 bg-green-500 text-white hover:bg-green-700']);
    }

    protected function canShowAction(CustomerSites $site): bool
    {
        if ($site->status == ApplicationStatus::INCOMPLETE) {
            return true;
        }


        return false;
    }


    /**
     * Approve data function.
     *
     */
    private function _submit(): \Closure
    {
        return function (array $data, CustomerSites $site): bool {

            $site->update(['status' => ApplicationStatus::SUBMITTED]);
            

            Notification::make()
                ->title('Submitted successfully')
                ->success()
                ->send();
            return true;
        };
    }
}
