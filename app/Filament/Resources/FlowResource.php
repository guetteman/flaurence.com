<?php

namespace App\Filament\Resources;

use App\Domain\Graphs\Newsletter\NewsletterGraph;
use App\Enums\FlowInputSchemaTypeEnum;
use App\Enums\FlowOutputTypeEnum;
use App\Enums\TextInputTypeEnum;
use App\Filament\Resources\FlowResource\Pages;
use App\Models\Flow;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class FlowResource extends Resource
{
    protected static ?string $model = Flow::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('external_id')
                    ->required()
                    ->options([
                        NewsletterGraph::ID => 'Personal Newsletter',
                    ]),
                Forms\Components\TextInput::make('short_description')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Builder::make('input_schema')
                    ->required()
                    ->columnSpanFull()
                    ->blocks([
                        Forms\Components\Builder\Block::make(FlowInputSchemaTypeEnum::TextInput->value)
                            ->label(FlowInputSchemaTypeEnum::TextInput->getLabel())
                            ->schema([
                                Forms\Components\TextInput::make('id')
                                    ->required()
                                    ->maxLength(255)
                                    ->readOnly()
                                    ->default(fn () => Str::uuid()->toString()),
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('description')
                                    ->required(),
                                Forms\Components\Select::make('type')
                                    ->required()
                                    ->options(TextInputTypeEnum::class),
                            ]),

                        Forms\Components\Builder\Block::make(FlowInputSchemaTypeEnum::ArrayInput->value)
                            ->label(FlowInputSchemaTypeEnum::ArrayInput->getLabel())
                            ->schema([
                                Forms\Components\TextInput::make('id')
                                    ->required()
                                    ->maxLength(255)
                                    ->readOnly()
                                    ->default(fn () => Str::uuid()->toString()),
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('description')
                                    ->required(),
                                Forms\Components\Textarea::make('placeholder')
                                    ->required(),
                            ]),
                    ]),
                Forms\Components\Select::make('output_type')
                    ->required()
                    ->options(FlowOutputTypeEnum::class)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('enabled')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('external_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('short_description')
                    ->searchable(),
                Tables\Columns\IconColumn::make('enabled')
                    ->boolean(),
                Tables\Columns\TextColumn::make('output_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListFlows::route('/'),
            'create' => Pages\CreateFlow::route('/create'),
            'edit' => Pages\EditFlow::route('/{record}/edit'),
        ];
    }
}
