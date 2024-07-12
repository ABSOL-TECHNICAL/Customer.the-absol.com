<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentTypesResource\Pages;
use App\Filament\Resources\DocumentTypesResource\RelationManagers;
use App\Models\DocumentTypes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class DocumentTypesResource extends Resource
{
    protected static ?string $model = DocumentTypes::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-minus';
    protected static ?string $navigationGroup = 'Catalog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Document Type')
                ->schema([     
                Forms\Components\TextInput::make('document_type_name')
                ->label('Name')
                ->columnSpan('full')
                ->regex('/^[a-zA-Z1-9\s]+$/'),
                Forms\Components\Radio::make('document_type_required')
                ->label('Required')
                ->inline()
                ->columnSpan('full')
                ->options([
                    '1'=> 'Yes',
                    '0'=> 'No',
                ]),
                Forms\Components\Toggle::make('document_type_status')
                ->label('Status')
                ->columnSpan('full')
                ,
                ])->columns(2)
                ->columnSpan(1)
                ->inlineLabel(true)
                ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('document_type_name')
                ->label('Name')->searchable(),
                Tables\Columns\ToggleColumn::make('document_type_required')
                ->label('Required'),
                Tables\Columns\ToggleColumn::make('document_type_status')
                ->label('Status'),
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
            'index' => Pages\ListDocumentTypes::route('/'),
            'create' => Pages\CreateDocumentTypes::route('/create'),
            'edit' => Pages\EditDocumentTypes::route('/{record}/edit'),
        ];
    }
}