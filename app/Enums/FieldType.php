<?php

namespace App\Enums;

use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum FieldType: string implements HasLabel, HasDescription, HasIcon
{
    case Text = 'text';
    case Email = 'email';
    case Url = 'url';
    case Number = 'number';
    case Markdown = 'markdown';
    case Select = 'select';
    case Boolean = 'boolean';
    case Date = 'date';
    case Time = 'time';
    case DateTime = 'date time';
    case Json = 'json';
    case Relation = 'relation';

    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Text => 'Text',
            self::Email => 'Email',
            self::Url => 'URL',
            self::Number => 'Number',
            self::Markdown => 'Markdown',
            self::Select => 'Select',
            self::Boolean => 'Yes/No',
            self::Date => 'Date',
            self::Time => 'Time',
            self::DateTime => 'Date/Time',
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
            self::Markdown => 'Formatted text with markdown support',
            self::Select => 'Single choice from predefined options',
            self::Boolean => 'True/false toggle value',
            self::Date => 'Calendar date without time',
            self::Time => 'Time of day without date',
            self::DateTime => 'Combined date and time value',
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
            self::Markdown => LucideIcon::TextSelect,
            self::Select => LucideIcon::Rows4,
            self::Boolean => LucideIcon::ToggleLeft,
            self::Date => LucideIcon::Calendar,
            self::Time => LucideIcon::Clock,
            self::DateTime => LucideIcon::CalendarClock,
            self::Json => LucideIcon::Braces,
            self::Relation => LucideIcon::Workflow,
        };
    }
}
