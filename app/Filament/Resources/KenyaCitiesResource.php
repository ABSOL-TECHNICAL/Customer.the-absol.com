<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KenyaCitiesResource\Pages;
use App\Filament\Resources\KenyaCitiesResource\RelationManagers;
use App\Models\KenyaCities;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class KenyaCitiesResource extends Resource
{
    protected static ?string $model = KenyaCities::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Catalog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Card::make()->schema([
                    Forms\Components\TextInput::make('city')
                        ->required()
                        ->label('Emirate Name')
                        ->regex('/^[a-zA-Z\s]+$/'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('id')->label('#'),
                Tables\Columns\TextColumn::make('city')->label('Emirate Name'),
                Tables\Columns\ToggleColumn::make('status'),
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
            'index' => Pages\ListKenyaCities::route('/'),
            'create' => Pages\CreateKenyaCities::route('/create'),
            'edit' => Pages\EditKenyaCities::route('/{record}/edit'),
        ];
    }
}
