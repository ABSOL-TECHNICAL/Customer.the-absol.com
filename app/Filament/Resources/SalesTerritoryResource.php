<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesTerritoryResource\Pages;
use App\Filament\Resources\SalesTerritoryResource\RelationManagers;
use App\Models\SalesTerritory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalesTerritoryResource extends Resource
{
    protected static ?string $model = SalesTerritory::class;

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                ->required()->hidden(),
                Forms\Components\TextInput::make('sales_territory')->label('Sales Territory')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')
                ->hidden(),
                TextColumn::make('sales_territory')
                ->label('Name')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSalesTerritories::route('/'),
            'create' => Pages\CreateSalesTerritory::route('/create'),
            'edit' => Pages\EditSalesTerritory::route('/{record}/edit'),
        ];
    }
}
