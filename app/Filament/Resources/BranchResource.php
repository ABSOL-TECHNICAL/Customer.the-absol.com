<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Filament\Resources\BranchResource\RelationManagers;
use App\Models\Bank;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Catalog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Section::make('Branch Details')
                ->description('Enter Branch Details')
                ->schema([
                    Forms\Components\TextInput::make('branch_code')
                    ->required()
                    ->alphaNum()
                    ->label('Code'),
                    Forms\Components\TextInput::make('branch_name')
                    ->required()
                    ->regex('/^[a-zA-Z\s]+$/')
                    ->label('Name'),
                    Forms\Components\Select::make('bank_id')
                    // ->relationship(name:'bank',titleAttribute:'bank_name')
                    ->options(fn(Get $get):Collection=>Bank::query()
                    ->where('bank_status','1')
                    ->pluck('Bank_name','id'))
                    // ->label('Branch Name')
                    ->label('Bank')
                    ->required(),
                    Forms\Components\Toggle::make('branch_status')
                    ->inline(false)
                    ->label('Status')
                    ->required(),
                ])
                ->columns(4)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('branch_code')->label('Code')->searchable(),
                Tables\Columns\TextColumn::make('branch_name')->label('Name')->searchable(),
                Tables\Columns\TextColumn::make('bank_id')->label('Bank Id'),
                Tables\Columns\ToggleColumn::make('branch_status')->label('Status'),
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
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}