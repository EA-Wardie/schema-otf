<?php

namespace App\Enums;

use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Str;

enum RelationFieldType: string implements HasDescription, HasLabel
{
    case Single = 'single';
    case Many = 'many';

    public function getLabel(): string|Htmlable|null
    {
        return Str::title($this->name);
    }

    public function getDescription(): string|Htmlable|null
    {
        return match ($this) {
            self::Single => 'Links to a single relational record',
            self::Many => 'Links to multiple relational records',
        };
    }
}
