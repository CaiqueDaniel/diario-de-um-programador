<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @property int $id
 * @property string $title
 * @property string $subtitle
 * @property string $article
 * @property string $permalink
 * @property string $thumbnail
 * @property string $created_at
 * @property string $updated_at
 */
class Post extends Model
{
    use HasFactory, SoftDeletes;

    private const LIMIT = 30;

    protected $fillable = ['title', 'subtitle', 'article'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'posts_categories', 'post', 'category');
    }

    public static function findAll(string $search = null): LengthAwarePaginator
    {
        /** @var Builder $builder */
        $builder = static::withTrashed();

        if (!empty($search))
            $builder->where('title', 'like', '%' . $search . '%');

        return $builder->with('author')->orderBy('id','desc')->paginate(self::LIMIT);
    }

    public static function findAllWithoutTrashed(string $search = null): LengthAwarePaginator
    {
        $builder = static::query();

        if (!empty($search))
            $builder->where('title', 'like', '%' . $search . '%');

        return $builder->with('author')->orderBy('id','desc')->paginate(self::LIMIT);
    }
}
