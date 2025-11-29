<?php

namespace App\Filament\Main\Resources\Collections\Pages;

use App\Filament\Main\Resources\Collections\CollectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListCollections extends ListRecords
{
    protected static string $resource = CollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalCloseButton(false)
                ->modalWidth(Width::Large)
                ->createAnother(false)
                ->stickyModalHeader()
                ->stickyModalFooter()
                ->slideOver(),
        ];
    }
}
