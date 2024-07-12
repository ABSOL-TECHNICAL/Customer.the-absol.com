<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderTypeResource\Pages;
use App\Filament\Resources\OrderTypeResource\RelationManagers;
use App\Models\OrderType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class OrderTypeResource extends Resource
{
    protected static ?string $model = OrderType::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationGroup = 'Catalog';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('order_type')->required()->alpha()->label('Order Type'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('id')->label('#'),
                Tables\Columns\TextColumn::make('order_type'),
                Tables\Columns\ToggleColumn::make('order_status'),
            ])
            ->headerActions([
                ExportAction::make('Export'),
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
            'index' => Pages\ListOrderTypes::route('/'),
            'create' => Pages\CreateOrderType::route('/create'),
            'edit' => Pages\EditOrderType::route('/{record}/edit'),
        ];
    }
}
