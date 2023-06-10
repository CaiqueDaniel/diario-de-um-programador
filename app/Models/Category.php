<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $permalink
 * @property string $deleted_at
 */
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
}
