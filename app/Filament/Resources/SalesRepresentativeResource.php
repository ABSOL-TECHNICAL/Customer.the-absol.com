<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesRepresentativeResource\Pages;
use App\Filament\Resources\SalesRepresentativeResource\RelationManagers;
use App\Models\SalesRepresentative;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalesRepresentativeResource extends Resource
{
    protected static ?string $model = SalesRepresentative::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Catalog';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('id')
            ->required()->hidden(),
            Forms\Components\TextInput::make('sales_representative')->label('Sales Representative')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')
                ->hidden(),
                TextColumn::make('sales_representative')
                ->label('Sales Persons')->searchable(),
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
            'index' => Pages\ListSalesRepresentatives::route('/'),
            'create' => Pages\CreateSalesRepresentative::route('/create'),
            'edit' => Pages\EditSalesRepresentative::route('/{record}/edit'),
        ];
    }
}
