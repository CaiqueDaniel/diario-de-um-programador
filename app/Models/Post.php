<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $title
 * @property string $subtitle
 * @property string $article
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'subtitle', 'article'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author');
    }
}
