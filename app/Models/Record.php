<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperRecord
 */
class Record extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'collection_id',
        'data',
        'published',
    ];

    protected $casts = [
        'data' => 'array',
        'published' => 'boolean',
    ];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }
}
