<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use App\Models\Country;
use App\Models\territory;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Set;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Collection;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationGroup = 'Catalog';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make()
            ->schema([
               Forms\Components\TextInput::make('id')->label('ID')
               ->hidden(),
            //    Forms\Components\Select::make('territory_id')
            //     ->relationship(name:'Territory',titleAttribute:'territory'),
            //    Forms\Components\Radio::make('Region')->options([
            //     'Kenya'=>'Kenya',
            //     'Outside Kenya'=>'Outside Kenya',
            // ])
            // ->live()
            // ->inline()
            
            // ->required(),
            // Forms\Components\Select::make('territory_id')->label("Territory")
            // ->visible(fn(Get $get):bool=>$get('Region')=='Kenya')
            // ->options(fn(Get $get):Collection=>territory::query()
            // ->where("status","1")
            // ->pluck("territory","id")
            // )
            // ->afterStateUpdated(fn(Set $set)=>$set('country_name','Kenya'))  
                // ->relationship(name:'Territory',titleAttribute:'territory') 
                // ->searchable()
                // ->preload()
                // ->required(),
            Forms\Components\TextInput::make('country_name')
            ->visible(fn(Get $get):bool=>$get('Region')=='Outside Kenya')
            ->required()->alpha(),
            //    Forms\Components\TextInput::make('country_name'),
               Forms\Components\TextInput::make('country_code')->alpha()->required(),
               Forms\Components\TextInput::make('country_phone_code')->tel()->required(),
            //    ->minLength(10)
            //    ->maxLength(15),
               Forms\Components\Toggle::make('country_status')->label('Active')->required(),
            ])
            ])->columns(1);
        
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make ('id')
                ->hidden(),
                TextColumn::make ('country_name')->searchable(),
                TextColumn::make('country_code')->searchable(),
                TextColumn::make('country_phone_code')->searchable(),
                ToggleColumn::make('country_status')->label('Active'),
                // TextColumn::make('Region')
            ])
            ->headerActions([
                ExportAction::make('Export'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                  
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
];
}
}