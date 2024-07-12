<?php

namespace App\Filament\Actions;

use App\Enums\ApplicationStatus;
use App\Models\CustomerSites;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;

class ReSubmitAction extends Action
{

    public static function getDefaultName(): ?string
    {
        return 'ReSubmit';
    }
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('success')
            ->action($this->reSubmit())
            ->icon('heroicon-m-check')
            ->label('Re submit')
            ->visible(function (CustomerSites $site) {
                return $this->canShowAction($site);
            })
            ->requiresConfirmation()
            ->modalDescription('Are you sure you want to submit your application?')
            ->extraAttributes(['class' => 'rounded-full py-2 bg-green-500 text-white hover:bg-green-700']);
    }

    protected function canShowAction(CustomerSites $site): bool
    {
        if ($site->status == ApplicationStatus::REJECTED) {
            return true;
        }


        return false;
    }


    /**
     * Approve data function.
     *
     */
    private function reSubmit(): \Closure
    {
        return function (array $data, CustomerSites $site): bool {

            $site->update(['status' => ApplicationStatus::SUBMITTED]);

            Notification::make()
                ->title('ReSubmitted successfully')
                ->success()
                ->send();
            return true;
        };
    }
}
