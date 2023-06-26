<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string $image
 * @property int $position
 */
class FullBanner extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    protected $fillable = ['title', 'link', 'image', 'position'];
}
