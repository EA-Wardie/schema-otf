<?php

namespace App\Filament\Main\Resources\Collections\Tables;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Size;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CollectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->filtersTriggerAction(fn(Action $action) => $action->size(Size::Medium)
                ->button())
            ->columns([
                TextColumn::make('name'),
                IconColumn::make('published')
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('published'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->modalSubmitActionLabel('Save')
                    ->modalCloseButton(false)
                    ->modalWidth(Width::Large)
                    ->slideOver(),
            ]);
    }
}
