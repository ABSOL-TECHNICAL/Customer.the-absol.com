<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurrencyResource\Pages;
use App\Filament\Resources\CurrencyResource\RelationManagers;
use App\Models\Currency;
use App\Models\Symbol;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class CurrencyResource extends Resource
{
    protected static ?string $model = Currency::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Catalog';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Currency Details')
                ->description('Enter Currency Details')
                ->schema([
                    Forms\Components\TextInput::make('currency_name')
                    ->required()
                    ->regex('/^[a-zA-Z\s]+$/')
                    ->label('Name'),
                    Forms\components\TextInput::make('currency_symbol')
                    ->label('Symbol')
                    ->regex('/^[^\w\s]+$/')
                    ->required(),
                    Forms\Components\TextInput::make('currency_code')
                    ->alpha()
                    ->required(),
                    Forms\Components\Toggle::make('currency_status')
                    ->label('Status')
                    ->inline(false)
                    ->required(),
                ])->columnSpan(1)
                ->columns(2),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#'),
                Tables\Columns\TextColumn::make('currency_name')->label('Name')->searchable(),
                Tables\Columns\TextColumn::make('currency_symbol')->label('Symbol')->searchable(),
                Tables\Columns\ToggleColumn::make('currency_status')->label('Status'),
                //
            ])
            ->headerActions([
                ExportAction::make('Export'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListCurrencies::route('/'),
            'create' => Pages\CreateCurrency::route('/create'),
            // 'view' => Pages\ViewCurrency::route('/{record}'),
            'edit' => Pages\EditCurrency::route('/{record}/edit'),
        ];
    }
}