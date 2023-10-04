<?php

namespace App\Dtos\Category;

use Illuminate\Contracts\Support\Arrayable;

class CategoryDto implements Arrayable
{
    public function __construct(
        public readonly string   $name,
        public readonly int|null $parent = null
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'parent' => $this->parent
        ];
    }
}
