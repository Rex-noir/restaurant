<?php

namespace App\Filament\Resources\MenuItemResource\RelationManagers;

use App\enums\MenuOptionTypesEnum;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'options';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('type')
                    ->options(MenuOptionTypesEnum::class)
                    ->native(false)
                    ->default(MenuOptionTypesEnum::CHECKBOX),

                Forms\Components\Repeater::make('values')
                    ->relationship()
                    ->columnSpanFull()
                    ->grid(3)
                    ->schema([
                        Forms\Components\TextInput::make('value')
                            ->required()
                            ->label('Value Name'),

                        Forms\Components\TextInput::make('price_mod')
                            ->numeric()
                            ->prefix('INR')
                            ->default(0)
                            ->label('Price Modifier'),

                        Forms\Components\Toggle::make('is_default')
                            ->label('Default')
                            ->reactive()
                            ->afterStateUpdated(function ($state, Forms\Components\Toggle $component, Set $set, Get $get) {
                                if ($state) {
                                    $items = $get('../');

                                    foreach ($items as $key => $item) {
                                        if ($item['is_default']) {
                                            $set("../$key.is_default", false);
                                        }
                                    }

                                    $set('is_default', true);
                                }
                            }),
                    ])
                    ->defaultItems(3)
                    ->itemLabel(fn (array $state): ?string => ($state['value']) ?? null)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('values_count')
                    ->counts('values')
                    ->alignCenter(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
