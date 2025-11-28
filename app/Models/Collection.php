<?php

namespace App\Models;

use App\Observers\CollectionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperCollection
 */
#[ObservedBy(CollectionObserver::class)]
class Collection extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'slug',
        'schema',
        'published',
    ];

    protected $casts = [
        'schema' => 'array',
        'published' => 'boolean',
    ];

    public function records(): HasMany
    {
        return $this->hasMany(Record::class);
    }
}
