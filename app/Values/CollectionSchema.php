<?php

namespace App\Values;

use App\Enums\FieldType;
use App\Enums\RelationFieldType;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class CollectionSchema implements Arrayable, JsonSerializable
{
    public string $name;

    public string $slug;

    public FieldType $type;

    public int $collection;

    public RelationFieldType $cardinality;

    public bool $required;

    public int $min_length;

    public int $max_length;

    public int $min;

    public int $max;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->slug = $data['slug'];
        $this->type = $data['type'];
        $this->collection = $data['collection'];
        $this->cardinality = $data['cardinality'];
        $this->required = $data['required'];
        $this->min_length = $data['min_length'];
        $this->max_length = $data['max_length'];
        $this->min = $data['min'];
        $this->max = $data['max'];
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'type' => $this->type,
            'collection' => $this->collection,
            'cardinality' => $this->cardinality,
            'required' => $this->required,
            'min_length' => $this->min_length,
            'max_length' => $this->max_length,
            'min' => $this->min,
            'max' => $this->max,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
