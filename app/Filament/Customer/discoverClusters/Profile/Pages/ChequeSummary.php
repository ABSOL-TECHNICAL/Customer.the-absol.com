<?php

namespace App\Filament\Customer\discoverClusters\Profile\Pages;

use App\Models\Api;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Customer\discoverClusters\Profile;
use Filament\Pages\SubNavigationPosition;
use Barryvdh\DomPDF\Facade\Pdf;
use Collection;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Blade;

class ChequeSummary extends Page
{
    public ?array $data = null;

    protected static ?string $title = 'CHEQUE STATUS-SUMMARY';
    protected static ?string $cluster = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static string $view = 'filament.customer.cheque-summary';

    public function mount()
    {
        $this->data = Api::chequeSummary(auth()->user());
        
    }



    protected function getFilterForms(): array
    {
        return [
            TextInput::make('year')
            ->regex('/^[0-9\s]+$/')
            ->label('Year'),

        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('CHEQUE STATUS-SUMMARY');
    }
    protected function getHeaderActions(): array
{
    return [
        Action::make('Filter')
        ->form($this->getFilterForms())
        ->action(function(array $data){
            $year=$data['year'];
        $this->data = Api::chequeSummaryWithDate(auth()->user(),$year);
        }),
        Action::make('Export pdf')
        ->url(function(){$customer = auth()->user();
            return route('downloadsummary.test', ['customer'=>$customer]);})
                ->icon('heroicon-m-arrow-down-tray')
                ->openUrlInNewTab()
                // ->deselectRecordsAfterCompletion()
                ->action(function (Collection $records) {
                    return response()->streamDownload(function () use ($records) {
                        echo Pdf::loadHTML(
                            Blade::render('pdf', ['records' => $records])
                        )->stream();
                    }, 'Customer Ageing Report.pdf');
                }),
    ];
}
    
}
