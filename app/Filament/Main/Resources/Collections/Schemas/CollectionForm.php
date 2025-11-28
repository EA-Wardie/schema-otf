<?php

namespace App\Filament\Main\Resources\Collections\Schemas;

use App\Enums\FieldType;
use App\Enums\RelationFieldType;
use App\Models\Collection;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\FusedGroup;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class CollectionForm
{
    public static function configure(Schema $schema): Schema
    {
        $collections = Collection::orderBy('nane')
            ->pluck('name', 'id');

        $types = collect(FieldType::cases())
            ->filter(function (FieldType $type) use ($collections) {
                if ($type === FieldType::Relation) {
                    return $collections->isNotEmpty();
                }

                return true;
            })
            ->mapWithKeys(fn(FieldType $type) => [$type->value => $type->getLabel()]);

        return $schema
            ->columns(1)
            ->components([
                FusedGroup::make([
                    TextInput::make('name')
                        ->prefix(new HtmlString('<pre>Name     </pre>'))
                        ->maxLength(255)
                        ->hiddenLabel()
                        ->required()
                        ->string(),
                    Select::make('published')
                        ->prefix(new HtmlString('<pre>Published</pre>'))
                        ->selectablePlaceholder(false)
                        ->default(true)
                        ->hiddenLabel()
                        ->required()
                        ->options([
                            true => 'Yes',
                            false => 'No',
                        ]),
                ]),
                Repeater::make('schema')
                    ->itemLabel(fn(array $state): ?string => $state['name'] ?? '[Field Name]')
                    ->addActionLabel('Add field')
                    ->defaultItems(1)
                    ->label('Fields')
                    ->minItems(1)
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        FusedGroup::make([
                            TextInput::make('name')
                                ->prefix(new HtmlString('<pre>Name       </pre>'))
                                ->maxLength(255)
                                ->columnSpanFull()
                                ->hiddenLabel()
                                ->required()
                                ->string()
                                ->live(),
                            Select::make('type')
                                ->prefix(new HtmlString('<pre>Type       </pre>'))
                                ->selectablePlaceholder(false)
                                ->default(FieldType::Text)
                                ->options($types)
                                ->hiddenLabel()
                                ->required(),
                            Select::make('collection')
                                ->requiredIf('type', FieldType::Relation)
                                ->prefix(new HtmlString('<pre>Collection </pre>'))
                                ->selectablePlaceholder(false)
                                ->options($collections)
                                ->default(false)
                                ->hiddenLabel()
                                ->visibleJs(<<<'JS'
                                    $get('type') === 'relation'
                                    JS
                                ),
                            Select::make('cardinality')
                                ->requiredIf('type', FieldType::Relation)
                                ->prefix(new HtmlString('<pre>Cardinality</pre>'))
                                ->options(RelationFieldType::class)
                                ->default(RelationFieldType::Single)
                                ->selectablePlaceholder(false)
                                ->hiddenLabel()
                                ->visibleJs(<<<'JS'
                                    $get('type') === 'relation'
                                    JS
                                ),
                            Select::make('required')
                                ->prefix(new HtmlString('<pre>Required   </pre>'))
                                ->selectablePlaceholder(false)
                                ->default(0)
                                ->hiddenLabel()
                                ->options([
                                    1 => 'Yes',
                                    0 => 'No',
                                ])
                                ->visibleJs(<<<'JS'
                                    $get('type') !== 'boolean'
                                    JS
                                ),
                            TextInput::make('min_length')
                                ->prefix(new HtmlString('<pre>Min Length </pre>'))
                                ->maxLength(3)
                                ->maxValue(255)
                                ->hiddenLabel()
                                ->numeric()
                                ->visibleJs(<<<'JS'
                                    ['text', 'email', 'url'].includes($get('type'))
                                    JS
                                ),
                            TextInput::make('max_length')
                                ->prefix(new HtmlString('<pre>Max Length </pre>'))
                                ->maxLength(3)
                                ->maxValue(255)
                                ->default(255)
                                ->hiddenLabel()
                                ->numeric()
                                ->visibleJs(<<<'JS'
                                    ['text', 'email', 'url'].includes($get('type'))
                                    JS
                                ),
                            TextInput::make('min')
                                ->prefix(new HtmlString('<pre>Min        </pre>'))
                                ->maxLength(255)
                                ->hiddenLabel()
                                ->numeric()
                                ->visibleJs(<<<'JS'
                                    $get('type') === 'number'
                                    JS
                                ),
                            TextInput::make('max')
                                ->prefix(new HtmlString('<pre>Max        </pre>'))
                                ->maxLength(255)
                                ->hiddenLabel()
                                ->numeric()
                                ->visibleJs(<<<'JS'
                                    $get('type') === 'number'
                                    JS
                                ),
                        ]),
                    ]),
            ]);
    }
}
