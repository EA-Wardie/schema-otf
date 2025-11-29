<?php

namespace App\Filament\Main\Resources\Collections\Pages;

use App\Enums\FieldType;
use App\Filament\Main\Resources\Collections\CollectionResource;
use App\Models\Collection;
use Arr;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ViewCollection extends ManageRelatedRecords
{
    protected static string $resource = CollectionResource::class;

    protected static string $relationship = 'records';

    public Model|Collection|int|string|null $record;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth(Width::Large)
                ->createAnother(false)
                ->stickyModalHeader()
                ->stickyModalFooter()
                ->slideOver(),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components(fn() => collect($this->record->schema)
                ->map(fn(array $field) => FieldType::from(Arr::get($field, 'type'))
                    ->getField($field))
                ->toArray());
    }

    public function table(Table $table): Table
    {
        return $table
            ->filtersTriggerAction(fn(Action $action) => $action->button())
            ->emptyStateHeading('No Records')
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
