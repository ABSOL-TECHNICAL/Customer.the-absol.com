<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyTypesResource\Pages;
use App\Filament\Resources\CompanyTypesResource\RelationManagers;
use App\Models\CompanyTypes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class CompanyTypesResource extends Resource
{
    protected static ?string $model = CompanyTypes::class;
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('Company Types')
            ->schema([
                Forms\Components\TextInput::make('company_type_name')->label('Name') ->regex('/^[a-zA-Z\s]+$/')->required(),
                Forms\Components\Toggle::make('legal_information_restriction')->label('Legal Information Restriction'),
            ]) 
            ->columnSpan(1)
            ->inlineLabel(true)
                //
            ]);
    }   

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('No'),
                Tables\Columns\TextColumn::make('company_type_name')->label('Name')->searchable(),
                Tables\Columns\ToggleColumn::make('legal_information_restriction')->label('Legal Information Restriction'),
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
            'index' => Pages\ListCompanyTypes::route('/'),
            'create' => Pages\CreateCompanyTypes::route('/create'),
            'edit' => Pages\EditCompanyTypes::route('/{record}/edit'),
        ];
    }
}