<?php

namespace App\Filament\Main\Resources\Collections\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CollectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                IconColumn::make('published')
                    ->boolean(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->modalWidth(Width::Large)
                    ->slideOver(),
                EditAction::make()
                    ->modalWidth(Width::Large)
                    ->slideOver(),
            ]);
    }
}
