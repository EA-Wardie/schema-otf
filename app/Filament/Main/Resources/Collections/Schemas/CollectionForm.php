<?php

namespace App\Filament\Main\Resources\Collections\Schemas;

use App\Enums\FieldType;
use App\Enums\RelationFieldType;
use App\Models\Collection;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class CollectionForm
{
    public static function configure(Schema $schema): Schema
    {
        $collections = Collection::orderBy('nane')
            ->pluck('name', 'id');

        $types = collect(FieldType::cases())
            ->filter(fn (FieldType $type) => ! ($type === FieldType::Relation) || $collections->isNotEmpty())
            ->mapWithKeys(fn (FieldType $type) => [$type->value => $type->getLabel()]);

        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->placeholder('Name')
                    ->maxLength(255)
                    ->hiddenLabel()
                    ->required()
                    ->string(),
                Checkbox::make('published')
                    ->default(true),
                Repeater::make('schema')
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? '[Field Name]')
                    ->extraAttributes(['class' => '[&_.fi-sc-has-gap]:gap-4'])
                    ->addActionLabel('Add Field')
                    ->defaultItems(1)
                    ->label('Fields')
                    ->minItems(1)
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Grid::make()
                            ->columns()
                            ->schema([
                                Select::make('type')
                                    ->selectablePlaceholder(false)
                                    ->placeholder('Type')
                                    ->default(FieldType::Text)
                                    ->options($types)
                                    ->required()
                                    ->live(),
                                TextInput::make('name')
                                    ->placeholder('Name')
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->required()
                                    ->string(),
                                TagsInput::make('options')
                                    ->requiredIf('type', FieldType::Select)
                                    ->placeholder('Options')
                                    ->columnSpanFull()
                                    ->reorderable()
                                    ->visibleJs(<<<'JS'
                                        $get('type') === 'select'
                                        JS
                                    ),
                                Select::make('collection')
                                    ->requiredIf('type', FieldType::Relation)
                                    ->selectablePlaceholder(false)
                                    ->placeholder('Collection')
                                    ->default($collections->first())
                                    ->options($collections)
                                    ->visibleJs(<<<'JS'
                                        $get('type') === 'relation'
                                        JS
                                    ),
                                Select::make('cardinality')
                                    ->requiredIf('type', FieldType::Relation)
                                    ->options(RelationFieldType::class)
                                    ->default(RelationFieldType::Single)
                                    ->selectablePlaceholder(false)
                                    ->placeholder('Cardinality')
                                    ->visibleJs(<<<'JS'
                                        $get('type') === 'relation'
                                        JS
                                    ),
                                TextInput::make('min_length')
                                    ->placeholder('Min Length')
                                    ->maxLength(3)
                                    ->maxValue(255)
                                    ->numeric()
                                    ->visibleJs(<<<'JS'
                                        ['text', 'email', 'url'].includes($get('type'))
                                        JS
                                    ),
                                TextInput::make('max_length')
                                    ->placeholder('Max Length')
                                    ->maxLength(3)
                                    ->maxValue(255)
                                    ->default(255)
                                    ->numeric()
                                    ->visibleJs(<<<'JS'
                                        ['text', 'email', 'url'].includes($get('type'))
                                        JS
                                    ),
                                TextInput::make('min')
                                    ->placeholder('Min Value')
                                    ->maxLength(255)
                                    ->numeric()
                                    ->visibleJs(<<<'JS'
                                        $get('type') === 'number'
                                        JS
                                    ),
                                TextInput::make('max')
                                    ->placeholder('Max Value')
                                    ->maxLength(255)
                                    ->numeric()
                                    ->visibleJs(<<<'JS'
                                        $get('type') === 'number'
                                        JS
                                    ),
                                Checkbox::make('required')
                                    ->default(false)
                                    ->visibleJs(<<<'JS'
                                        $get('type') !== 'boolean'
                                        JS
                                    ),
                            ]),
                        //                        Group::make()
                        //                            ->visibleJs(fn(string $operation) => $operation === 'create')
                        //                            ->extraAttributes(['class' => 'gap-x-4'])
                        //                            ->columns()
                        //                            ->schema([
                        //                                Select::make('type')
                        //                                    ->selectablePlaceholder(false)
                        //                                    ->placeholder('Type')
                        //                                    ->default(FieldType::Text)
                        //                                    ->options($types)
                        //                                    ->required(),
                        //                                TextInput::make('name')
                        //                                    ->placeholder('Name')
                        //                                    ->maxLength(255)
                        //                                    ->live(onBlur: true)
                        //                                    ->required()
                        //                                    ->string(),
                        //                            ]),
                        //                        TagsInput::make('options')
                        //                            ->reorderable()
                        //                            ->required()
                        //                            ->visibleJs(<<<'JS'
                        //                                $get('type') === 'select'
                        //                                JS
                        //                            ),
                        //                        Group::make()
                        //                            ->extraAttributes(['class' => 'gap-x-4'])
                        //                            ->columns()
                        //                            ->schema([
                        //                                Select::make('collection')
                        //                                    ->requiredIf('type', FieldType::Relation)
                        //                                    ->selectablePlaceholder(false)
                        //                                    ->placeholder('Collection')
                        //                                    ->options($collections)
                        //                                    ->visibleJs(<<<'JS'
                        //                                    $get('type') === 'relation'
                        //                                    JS
                        //                                    ),
                        //                                Select::make('cardinality')
                        //                                    ->requiredIf('type', FieldType::Relation)
                        //                                    ->options(RelationFieldType::class)
                        //                                    ->default(RelationFieldType::Single)
                        //                                    ->selectablePlaceholder(false)
                        //                                    ->placeholder('Cardinality')
                        //                                    ->visibleJs(<<<'JS'
                        //                                    $get('type') === 'relation'
                        //                                    JS
                        //                                    ),
                        //                            ])
                        //                            ->visibleJs(<<<'JS'
                        //                                    $get('type') === 'relation'
                        //                                    JS
                        //                            ),
                        //                        Group::make()
                        //                            ->extraAttributes(['class' => 'gap-x-4'])
                        //                            ->columns()
                        //                            ->schema([
                        //                                TextInput::make('min_length')
                        //                                    ->placeholder('Min Length')
                        //                                    ->maxLength(3)
                        //                                    ->maxValue(255)
                        //                                    ->numeric()
                        //                                    ->visibleJs(<<<'JS'
                        //                                    ['text', 'email', 'url'].includes($get('type'))
                        //                                    JS
                        //                                    ),
                        //                                TextInput::make('max_length')
                        //                                    ->placeholder('Max Length')
                        //                                    ->maxLength(3)
                        //                                    ->maxValue(255)
                        //                                    ->default(255)
                        //                                    ->numeric()
                        //                                    ->visibleJs(<<<'JS'
                        //                                    ['text', 'email', 'url'].includes($get('type'))
                        //                                    JS
                        //                                    ),
                        //                                TextInput::make('min')
                        //                                    ->placeholder('Min Value')
                        //                                    ->maxLength(255)
                        //                                    ->numeric()
                        //                                    ->visibleJs(<<<'JS'
                        //                                    $get('type') === 'number'
                        //                                    JS
                        //                                    ),
                        //                                TextInput::make('max')
                        //                                    ->placeholder('Max Value')
                        //                                    ->maxLength(255)
                        //                                    ->numeric()
                        //                                    ->visibleJs(<<<'JS'
                        //                                    $get('type') === 'number'
                        //                                    JS
                        //                                    ),
                        //                            ]),
                        //                        Checkbox::make('required')
                        //                            ->default(false)
                        //                            ->visibleJs(<<<'JS'
                        //                                    $get('type') !== 'boolean'
                        //                                    JS
                        //                            ),
                    ]),
            ]);
    }
}
