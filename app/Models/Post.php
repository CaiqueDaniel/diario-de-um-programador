<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @property string $title
 * @property string $subtitle
 * @property string $article
 */
class Post extends Model
{
    use HasFactory;

    const LIMIT = 30;

    protected $fillable = ['title', 'subtitle', 'article'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author');
    }

    public static function findAll(int $offset = 0, string $search = null): LengthAwarePaginator
    {
        /** @var Builder $builder */
        $builder = static::select('*');

        if (!empty($search))
            $builder->where('title', 'like', '%' . $search . '%');

        return $builder->with('author')->limit(self::LIMIT)->offset($offset * self::LIMIT)->paginate();
    }
}
