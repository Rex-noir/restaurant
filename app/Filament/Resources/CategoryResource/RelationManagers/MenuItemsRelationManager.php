<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Tags\Tag;

class MenuItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'menuItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(65535),

                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),

                Forms\Components\TextInput::make('preparation_time')
                    ->numeric()
                    ->prefix('min'),

                Forms\Components\FileUpload::make('image_path')
                    ->columnSpanFull()
                    ->directory('images/menu-items')
                    ->image()
                    ->previewable()
                    ->imageEditor(),

                SpatieTagsInput::make('tags')
                    ->type('menu_item_tags')
                    ->columnSpanFull()
                    ->suggestions(Tag::query()->where('type', '=', 'menu_item_tags')->pluck('name')->toArray()),

                Forms\Components\Toggle::make('is_available')
                    ->required(),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
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
