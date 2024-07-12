<?php

namespace App\Filament\Resources;
use App\Filament\Resources\DocumentsResource\Pages;
use App\Filament\Resources\DocumentsResource\Pages\RelationManagers\LegalInformationsRelationManager;
use App\Filament\Resources\DocumentsResource\Pages\RelationManagers\OtherDocumentsRelationManager;
use App\Models\Documents;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class DocumentsResource extends Resource
{
    protected static ?string $model = Documents::class;
    protected static ?string $navigationLabel="Global Documents";
    protected static ?string $modelLabel='Global Documents';
    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('PhysicalInformations.name')->label('Name'),
                TextColumn::make('PhysicalInformations.name_of_the_company')->label('Company Name'),
            ])
            ->headerActions([
                ExportAction::make('Export'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocuments::route('/create'),
            'view' => Pages\ViewDocuments::route('/{record}'),
            'edit' => Pages\EditDocuments::route('/{record}/edit'),
        ];
    }
}
