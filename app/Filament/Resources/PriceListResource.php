<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PriceListResource\Pages;
use App\Filament\Resources\PriceListResource\RelationManagers;
use App\Models\PriceList;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class PriceListResource extends Resource
{
    protected static ?string $model = PriceList::class;
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                ->required()->hidden(),
                Forms\Components\TextInput::make('Price_list_name')->required(),
                Forms\Components\Toggle::make('Status')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')
                ->hidden(),
                TextColumn::make('Price_list_name')
                ->label('Name')->searchable(),
                IconColumn::make('Status')
                ->boolean(),

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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPriceLists::route('/'),
            'create' => Pages\CreatePriceList::route('/create'),
            'edit' => Pages\EditPriceList::route('/{record}/edit'),
        ];
    }
}