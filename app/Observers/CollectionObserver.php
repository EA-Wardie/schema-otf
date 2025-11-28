<?php

namespace App\Observers;

use App\Models\Collection;
use Str;

class CollectionObserver
{
    /**
     * Handle the Collection "creating" event.
     */
    public function creating(Collection $collection): void
    {
        $collection->slug = Str::slug($collection->name);

        $collection->schema = collect($collection->schema)
            ->map(fn(array $field) => [
                ...$field,
                'slug' => Str::slug($field['name']),
            ])
            ->toArray();
    }

    /**
     * Handle the Collection "created" event.
     */
    public function created(Collection $collection): void
    {
        //
    }

    /**
     * Handle the Collection "updating" event.
     */
    public function updating(Collection $collection): void
    {
        $collection->slug = Str::slug($collection->name);

        $collection->schema = collect($collection->schema)
            ->map(fn(array $field) => [
                ...$field,
                'slug' => Str::slug($field['name']),
            ])
            ->toArray();
    }

    /**
     * Handle the Collection "updated" event.
     */
    public function updated(Collection $collection): void
    {
        //
    }

    /**
     * Handle the Collection "deleted" event.
     */
    public function deleted(Collection $collection): void
    {
        //
    }

    /**
     * Handle the Collection "restored" event.
     */
    public function restored(Collection $collection): void
    {
        //
    }

    /**
     * Handle the Collection "force deleted" event.
     */
    public function forceDeleted(Collection $collection): void
    {
        //
    }
}
