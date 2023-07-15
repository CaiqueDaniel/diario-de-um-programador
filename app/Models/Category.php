<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};
use Illuminate\Support\Collection;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    protected $fillable = ['name'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'posts_categories', 'category', 'post');
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getPermalink(): string
    {
        return $this->attributes['permalink'];
    }

    public function setPermalink(string $value): self
    {
        $this->attributes['permalink'] = $value;
        return $this;
    }

    public static function findAll(string $search = null): Collection
    {
        /** @var Builder $builder */
        $builder = static::withTrashed();

        if (!empty($search))
            $builder->where('name', 'like', '%' . $search . '%');

        return $builder->get();
    }
}
