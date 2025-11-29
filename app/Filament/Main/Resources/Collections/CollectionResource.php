<?php

namespace App\Filament\Main\Resources\Collections;

use App\Filament\Main\Resources\Collections\Pages\ListCollections;
use App\Filament\Main\Resources\Collections\Pages\ViewCollection;
use App\Filament\Main\Resources\Collections\Schemas\CollectionForm;
use App\Filament\Main\Resources\Collections\Tables\CollectionsTable;
use App\Models\Collection;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CollectionResource extends Resource
{
    protected static ?string $model = Collection::class;

    public static function form(Schema $schema): Schema
    {
        return CollectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CollectionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCollections::route('/'),
            'view' => ViewCollection::route('/{record}'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
