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

class Soa extends Page
{
    public ?array $data = null;

    protected static ?string $title = 'STATEMENT OF ACCOUNTS';
    protected static ?string $cluster = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static string $view = 'filament.customer.soa';

    public function mount()
    {
        $this->data = Api::statement(auth()->user());
        
    }



    public function getTitle(): string | Htmlable
    {
        return __('STATEMENT OF ACCOUNTS');
    }
    protected function getHeaderActions(): array
{
    return [
        Action::make('Export pdf')
        ->url(function(){$customer = auth()->user();
            return route('downloadsoa.test', ['customer'=>$customer]);})
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
