<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcessApprovalFlowResource\Pages;
use App\Models\ProcessApprovalFlow;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Illuminate\Validation\Rule;

class ProcessApprovalFlowResource extends Resource
{
    protected static ?string $model = ProcessApprovalFlow::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $pluralModelLabel = 'Approval flows';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Approval Flow')
                    ->schema([
                        Select::make("role_id")
                            ->searchable()
                            ->label("Role")
                            ->helperText("Who should approve in this step?")
                            ->options(fn () => \App\Models\Role::get()
                                ->map(fn ($model) => [
                                    "name" => str($model->name)
                                        ->replace("_", " ")
                                        ->title()
                                        ->toString(),
                                    "id" => $model->id
                                ])->pluck("name", "id"))
                            ->native(false)
                            ->columns(5)
                            ->required()
                            ->rules([
                                function (callable $get) {
                                    return Rule::unique('process_approval_flows', 'role_id')
                                        ->ignore($get('record.id') ?? $get('id'));
                                },
                            ]),
                        Select::make("action")
                            ->helperText("What should be done in this step?")
                            ->native(false)
                            ->default("APPROVE")
                            ->options([
                                'APPROVE' => 'Approve',
                                'VERIFY' => 'Verify',
                                'CHECK' => 'Check',
                            ])
                            ->columns(5)
                            ->required(),
                        TextInput::make('order')
                            ->label('Order')
                            ->type('number')
                            ->columns(2)
                            ->default(fn () => ProcessApprovalFlow::max('order') + 1)
                            ->readOnly()
                            ->required(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('order')->label('Order'),
                Tables\Columns\TextColumn::make('role.name'),
                Tables\Columns\TextColumn::make('action'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-s-plus')
                    ->label('Add Flow'),
            ])
            ->actions([
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
            'index' => Pages\ListProcessApprovalFlows::route('/'),
            'create' => Pages\CreateProcessApprovalFlow::route('/create'),
            'edit' => Pages\EditProcessApprovalFlow::route('/{record}/edit'),
        ];
    }
}
