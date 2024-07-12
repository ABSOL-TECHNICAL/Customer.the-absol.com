<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TerritoryResource\Pages;
use App\Filament\Resources\TerritoryResource\RelationManagers;
use App\Models\Territory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class TerritoryResource extends Resource
{
    protected static ?string $model = Territory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Catalog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('country_id')
                ->label('Country Name')
                ->Required()
                ->relationship(name:'country',titleAttribute:'country_name'),
                // Forms\Components\Select::make('country_id')
                // ->relationship(name:'country',titleAttribute:'country_name'),
                Forms\Components\TextInput::make('territory')->label('Territory Name')->required(),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('id')->label('#'),
                Tables\Columns\TextColumn::make('territory')->label('Territory Name')->searchable(),
                Tables\Columns\TextColumn::make('country.country_name')->label('Country Name')->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                //
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
            'index' => Pages\ListTerritories::route('/'),
            'create' => Pages\CreateTerritory::route('/create'),
            'edit' => Pages\EditTerritory::route('/{record}/edit'),
        ];
    }
}