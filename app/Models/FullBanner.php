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
class FullBanner extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['title', 'link', 'image', 'position'];
}
