<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CollectorResource\Pages;
use App\Filament\Resources\CollectorResource\RelationManagers;
use App\Models\Collector;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class CollectorResource extends Resource
{
    protected static ?string $model = Collector::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    
    protected static ?string $navigationGroup = 'Catalog';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            //
            Forms\Components\TextInput::make('collector_name')
                ->required()
                ->regex('/^[a-zA-Z\s]+$/')
                ->label('Name'),
            Forms\Components\Toggle::make('collector_status')
                    ->label('Status')
                    ->required()
                    ->inline(false)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            //
            Tables\Columns\TextColumn::make('id')->label('ID'),
            Tables\Columns\TextColumn::make('collector_name')->label('Name')->searchable(),
            Tables\Columns\ToggleColumn::make('collector_status')->label('Status')->searchable(),
        
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
            'index' => Pages\ListCollectors::route('/'),
            'create' => Pages\CreateCollector::route('/create'),
            'edit' => Pages\EditCollector::route('/{record}/edit'),
        ];
    }
}
