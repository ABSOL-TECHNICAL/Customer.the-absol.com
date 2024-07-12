<?php

namespace App\Filament\Resources\CurrencyResource\Pages;

use App\Filament\Resources\CurrencyResource;
use App\Imports\ImportCurrencies;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ListCurrencies extends ListRecords
{
    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getHeader(): ?View
    {
        $data = Actions\CreateAction::make();
        return view('filament.custom.upload-currency', compact('data'));
    }

    public $file='';

    public function save()
    {
        // Check if no file is selected
        if (!$this->file) {
            session()->flash('error', 'Please select a file for import.');
            return;
        }

        try {
            if ($this->file != '') {
                Excel::import(new ImportCurrencies, $this->file);
            }
        
            session()->flash('success', 'Data Imported Successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Data File Format is wrong Please check your file.');
        }
    
    }
}
