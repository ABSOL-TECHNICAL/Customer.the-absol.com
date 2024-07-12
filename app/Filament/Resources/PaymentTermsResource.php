<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentTermsResource\Pages;
use App\Filament\Resources\PaymentTermsResource\RelationManagers;
use App\Models\PaymentTerms;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class PaymentTermsResource extends Resource
{
    protected static ?string $model = PaymentTerms::class;
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payment Term Details')
                ->description('Enter Details')
                ->schema([
                    Forms\Components\TextInput::make('payment_term_name')
                    ->regex('/^[a-zA-Z1-9\s]+$/')
                    ->label('Name')
                    ->required(),
                    Forms\Components\TextInput::make('payment_term_description')
                    ->label('Description')
                    ->regex('/^[a-zA-Z1-9\s]+$/')
                    ->required(),
                    Forms\Components\Toggle::make('payment_term_status')
                    ->inline(false)
                    ->label('Status')
                    ->required(),
                    Forms\Components\DatePicker::make('payment_term_end_date')
                    ->label('End Date')
                    ->required(),
                ])->columns(3)
                ,
               
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#'),
                Tables\Columns\TextColumn::make('payment_term_name')
                ->label('Name'),
                Tables\Columns\TextColumn::make('payment_term_description')
                ->label('Description'),
                Tables\Columns\ToggleColumn::make('payment_term_status')
                ->label('Status')
                ,
                Tables\Columns\TextColumn::make('payment_term_end_date')
                ->date()    
                ->label('End Date'),
                //
            ])
            ->headerActions([
                ExportAction::make('Export'),
            ])
            ->filters([
                Tables\Filters\Filter::make('search') 
                ->form([
                    TextInput::make('payment_term_name')
                    ->label('search')
                    ->reactive(),
                    
                ])  
                ->query(function(Builder $query, array $data):Builder{
                    return $query->where('payment_term_name','like','%'. $data['payment_term_name'] .'%');
                }),
                
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
            'index' => Pages\ListPaymentTerms::route('/'),
            'create' => Pages\CreatePaymentTerms::route('/create'),
            'edit' => Pages\EditPaymentTerms::route('/{record}/edit'),
        ];
    }
}