<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountTypeResource\Pages;
use App\Filament\Resources\AccountTypeResource\RelationManagers;
use App\Models\AccountType;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class AccountTypeResource extends Resource
{
    protected static ?string $model = AccountType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $pluralLabel = 'Customer Type';
    
    protected static ?string $navigationGroup = 'Catalog';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make()
            ->schema([
            Forms\Components\TextInput::make('type')
            ->label('Type')
            ->regex('/^[a-zA-Z\s]+$/')
            ->required(),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            //
            Tables\Columns\TextColumn::make('id')->label('#'),
            Tables\Columns\TextColumn::make('type')->label('Type'),
            
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
            'index' => Pages\ListAccountTypes::route('/'),
            'create' => Pages\CreateAccountType::route('/create'),
            'edit' => Pages\EditAccountType::route('/{record}/edit'),
        ];
    }
}
