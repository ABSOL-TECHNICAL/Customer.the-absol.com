<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Bank;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Symfony\Component\Yaml\Inline;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BankResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BankResource\RelationManagers;
use Filament\Facades\Filament;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class BankResource extends Resource
{
    protected static ?string $model = Bank::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Catalog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Bank Details')
                ->description('Enter Bank Details')
                ->schema(
                    [
                        Forms\Components\TextInput::make('bank_code')
                        ->required()
                        // ->alphaNum()
                        ->regex('/^[0-9\s]+$/')
                        ->label('Code'),
                        Forms\Components\TextInput::make('bank_name')
                        ->required()
                        ->regex('/^[a-zA-Z\s]+$/')
                        ->label('Name'),
                        Forms\Components\Toggle::make('bank_status')
                        ->label('Status')
                        ->required()
                        ->inline(false),
                    ]
                )
                ->inlineLabel(false)
                ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('bank_code')->label('Code')->searchable(),
                Tables\Columns\TextColumn::make('bank_name')->label('Name')->searchable(),
                Tables\Columns\ToggleColumn::make('bank_status')->label('Status'),
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
        // $id=Filament::auth()->check();
        // dd($id);

        return [
            'index' => Pages\ListBanks::route('/'),
            'create' => Pages\CreateBank::route('/create'),
            'edit' => Pages\EditBank::route('/{record}/edit'),
        ];
    }
}