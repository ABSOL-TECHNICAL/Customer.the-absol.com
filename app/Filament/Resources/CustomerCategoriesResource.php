<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerCategoriesResource\Pages;
use App\Filament\Resources\CustomerCategoriesResource\RelationManagers;
use App\Models\CustomerCategories;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class CustomerCategoriesResource extends Resource
{
    protected static ?string $model = CustomerCategories::class;
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $pluralLabel = 'Customer Class';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Customer Categories')
                ->description('Enter Details')
                ->schema([
                    Forms\Components\TextInput::make('customer_categories_name')
                    ->regex('/^[a-zA-Z\s]+$/')
                    ->label('Customer Category Name')
                    ->required(),
                    Forms\Components\Toggle::make('customer_categories_status')
                    ->label('Status')
                    ->inline(false)
                    ->required(),
                ])->columnSpan(1)
                ->columns(2),
                //
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_categories_name')
                ->label('Name'),
                Tables\Columns\ToggleColumn::make('customer_categories_status')
                    ->label('Status'),
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
            'index' => Pages\ListCustomerCategories::route('/'),
            'create' => Pages\CreateCustomerCategories::route('/create'),
            'edit' => Pages\EditCustomerCategories::route('/{record}/edit'),
        ];
    }
}
