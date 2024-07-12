<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page as PagesPage;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Password;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class UserResource extends Resource
{

    protected static ?string $label = 'Employees';
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->regex('/^[a-zA-Z\s]+$/'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->rules(['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'])
                    ->required(),
                Forms\Components\TextInput::make('password')
                ->revealable()
                ->password()
                ->live(onBlur:true)
                ->rule(Password::default()->min('5')->symbols()->numbers())
                ->required(fn(Page $livewire) => ($livewire instanceof CreateUser))
                ->visibleOn('create')
                ->afterStateUpdated(function ($state, $set) {
                    $set('visible_password', $state);
                }),
                Forms\Components\TextInput::make('visible_password')
                ->readOnly(),
                Forms\Components\Select::make('roles')->label('Designation')
                // ->multiple()
                ->relationship('roles','name')
                ->required()
                ->preload(),
                Forms\Components\Select::make('permissions')
                ->multiple()
                ->relationship('permissions','name')
                ->preload()
                //
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('No'),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('visible_password')->label('Password'),
                Tables\Columns\TextColumn::make('roles.name')->label('Designation')
                // ->password()
                // ->required()
                // ->visibleOn('create'),
                //
            ])
            ->headerActions([
                ExportAction::make('Export'),
            ])
            ->filters([
                // Tables\Filters\Filter::make('verified')
                // ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                //
            ])
            ->actions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                //
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent :: getEloquentQuery()->where('email','!=','jeevanrajece21@gmail.com');
    }
}
