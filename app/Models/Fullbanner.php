<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string $image
 * @property int $position
 */
class Fullbanner extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'link', 'image', 'position'];
}
