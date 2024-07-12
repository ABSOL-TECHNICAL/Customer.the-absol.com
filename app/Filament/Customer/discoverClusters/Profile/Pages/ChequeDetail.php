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
use Carbon\Carbon;
use Collection;
use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;

class ChequeDetail extends Page
{
    public ?array $data = null;

    protected static ?string $title = 'CHEQUE STATUS-DETAIL';
    protected static ?string $cluster = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static string $view = 'filament.customer.cheque-details';

    public function mount()
    {
        $this->data = Api::chequeDetail(auth()->user());
        
    }

    public function filterDate(){

        $data = $this->form->getState();
        $startDate=Carbon::parse($data['start_date']);
        $endDate=Carbon::parse($data['end_date']);
        $response = Api::chequeDetailWithDate(auth()->user(),$startDate,$endDate);
        dd($response);
        $data=$response->json();
        return view('filament.customer.cheque-details', compact('data'));


    }

    public function form(Form $form): Form
    {
        return $form;
    }
    protected function getFilterForms(): array
    {
        return [
            DatePicker::make('start_date')
            ->label('Start Date'),
            DatePicker::make('end_date')
            ->label('End Date'),

        ];
    }
    public function getTitle(): string | Htmlable
    {
        return __('CHEQUE STATUS-DETAIL');
    }
    protected function getHeaderActions(): array
{
    return [
        Action::make('Filter')
        ->form($this->getFilterForms())
        ->action(function(array $data){
            $startDate=Carbon::parse($data['start_date']);
        $endDate=Carbon::parse($data['end_date']);
        $this->data = Api::chequeDetailWithDate(auth()->user(),$startDate,$endDate);
        }),
        Action::make('Export pdf')
        ->url(function(){$customer = auth()->user();
            return route('downloadstatus.test', ['customer'=>$customer]);})
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
