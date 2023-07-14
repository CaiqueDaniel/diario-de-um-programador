<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};

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
}
