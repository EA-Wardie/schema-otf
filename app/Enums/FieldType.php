<?php

namespace App\Enums;

use App\Models\Collection;
use App\Models\Record;
use Arr;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

enum FieldType: string implements HasLabel, HasDescription, HasIcon
{
    case Text = 'text';
    case Email = 'email';
    case Url = 'url';
    case Number = 'number';
    case Select = 'select';
    case Boolean = 'boolean';
    case Date = 'date';
    case Time = 'time';
    case DateTime = 'date time';
    case Markdown = 'markdown';
    case Json = 'json';
    case Relation = 'relation';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Text => 'Text',
            self::Email => 'Email',
            self::Url => 'URL',
            self::Number => 'Number',
            self::Select => 'Select',
            self::Boolean => 'Yes/No',
            self::Date => 'Date',
            self::Time => 'Time',
            self::DateTime => 'Date/Time',
            self::Markdown => 'Markdown',
            self::Json => 'JSON',
            self::Relation => 'Relation',
        };
    }

    public function getDescription(): string|Htmlable|null
    {
        return match ($this) {
            self::Text => 'Plain text input without formatting',
            self::Email => 'Email address with validation',
            self::Url => 'Web URL with validation',
            self::Number => 'Numeric value (integer or decimal)',
            self::Select => 'Single choice from predefined options',
            self::Boolean => 'True/false toggle value',
            self::Date => 'Calendar date without time',
            self::Time => 'Time of day without date',
            self::DateTime => 'Combined date and time value',
            self::Markdown => 'Formatted text with markdown support',
            self::Json => 'Structured JSON data',
            self::Relation => 'Reference to another record',
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Text => LucideIcon::TextCursorInput,
            self::Email => LucideIcon::Mail,
            self::Url => LucideIcon::Link,
            self::Number => LucideIcon::Hash,
            self::Select => LucideIcon::Rows4,
            self::Boolean => LucideIcon::ToggleLeft,
            self::Date => LucideIcon::Calendar,
            self::Time => LucideIcon::Clock,
            self::DateTime => LucideIcon::CalendarClock,
            self::Markdown => LucideIcon::TextSelect,
            self::Json => LucideIcon::Braces,
            self::Relation => LucideIcon::Workflow,
        };
    }

    public function getField(array $field): Field
    {
        $name = Arr::get($field, 'name');
        $slug = Arr::get($field, 'slug');
        $key = "data.$slug";
        $required = (bool)Arr::get($field, 'required');
        $minLength = Arr::get($field, 'min_length');
        $maxLength = Arr::get($field, 'max_length', 255);
        $min = Arr::get($field, 'min');
        $max = Arr::get($field, 'min');
        $collectionId = Arr::get($field, 'collection');
        $cardinality = RelationFieldType::from(Arr::get($field, 'cardinality', 'single'));

        $options = collect(Arr::get($field, 'options', []))
            ->mapWithKeys(fn(mixed $value) => [$value => $value]);

        $textInput = TextInput::make($key)
            ->minLength($minLength)
            ->maxLength($maxLength)
            ->required($required)
            ->placeholder($name)
            ->minValue($min)
            ->maxValue($max);

        if ($this === self::Text) {
            return $textInput
                ->string();
        } elseif ($this === self::Email) {
            return $textInput
                ->email();
        } elseif ($this === self::Url) {
            return $textInput
                ->activeUrl()
                ->url();
        } elseif ($this === self::Number) {
            return $textInput
                ->numeric();
        } elseif ($this === self::Select) {
            return Select::make($key)
                ->placeholder($name)
                ->options($options);
        } elseif ($this === self::Boolean) {
            return Checkbox::make($key)
                ->default(false)
                ->columnSpanFull();
        } elseif ($this === self::Date) {
            return DatePicker::make($key)
                ->placeholder($name);
        } elseif ($this === self::Time) {
            return TimePicker::make($key)
                ->seconds(false)
                ->placeholder($name);
        } elseif ($this === self::DateTime) {
            return DateTimePicker::make($key)
                ->seconds(false)
                ->placeholder($name);
        } elseif ($this === self::Markdown) {
            return MarkdownEditor::make($key)
                ->required($required)
                ->placeholder($name)
                ->columnSpanFull()
                ->string()
                ->toolbarButtons([
                    ['heading'],
                    ['bold', 'italic', 'strike', 'link'],
                    ['blockquote', 'bulletList', 'orderedList'],
                    ['table'],
                    ['undo', 'redo'],
                ]);
        } elseif ($this === self::Json) {
            return CodeEditor::make($key)
                ->language(CodeEditor\Enums\Language::Json)
                ->columnSpanFull();
        } elseif ($this === self::Relation) {
            $records = Record::where('collection_id', $collectionId)
                ->pluck('id', 'id');

            $relationSelect = Select::make($key)
                ->required($required)
                ->placeholder($name)
                ->options($records);

            return match ($cardinality) {
                RelationFieldType::Single => $relationSelect,
                RelationFieldType::Many => $relationSelect
                    ->columnSpanFull()
                    ->multiple(),
            };
        }

        return Hidden::make();
    }

    public function getColumn(array $field): Column
    {
        $name = Arr::get($field, 'name');
        $slug = Arr::get($field, 'slug');
        $key = "data.$slug";

        $textColumn = TextColumn::make($key)
            ->label($name);

        return match ($this) {
            self::Text => $textColumn,
            self::Email => $textColumn
                ->url(fn(?string $state) => "mailto:$state")
                ->openUrlInNewTab(),
            self::Url => $textColumn
                ->url(fn(?string $state) => $state)
                ->openUrlInNewTab(),
            self::Number => $textColumn
                ->color('primary'),
            self::Select => $textColumn
                ->badge(),
            self::Boolean => IconColumn::make($key)
                ->label($name)
                ->boolean(),
            self::Date => $textColumn
                ->date(),
            self::Time => $textColumn
                ->time('H:m'),
            self::DateTime => $textColumn
                ->dateTime('M d, Y H:m'),
            self::Markdown => $textColumn
                ->markdown(),
            self::Json => $textColumn,
            self::Relation => $textColumn
                ->badge(),
        };
    }
}
