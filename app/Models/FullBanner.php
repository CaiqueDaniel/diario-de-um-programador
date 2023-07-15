<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes};

class FullBanner extends Model
{
    use HasFactory, SoftDeletes;

    private const LIMIT = 30;

    public $timestamps = false;
    protected $fillable = ['title', 'link', 'image', 'position'];

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getTitle(): string
    {
        return $this->attributes['title'];
    }

    public function getLink(): string
    {
        return $this->attributes['link'];
    }

    public function getImage(): string
    {
        return $this->attributes['image'];
    }

    public function getPosition(): int
    {
        return $this->attributes['position'];
    }

    public function setTitle(string $value): string
    {
        return $this->attributes['title'] = $value;
    }

    public function setLink(string $value): string
    {
        return $this->attributes['link'] = $value;
    }

    public function setImage(string $value): string
    {
        return $this->attributes['image'] = $value;
    }

    public function setPosition(int $value): int
    {
        return $this->attributes['position'] = $value;
    }

    public static function findAll(string $search = null): LengthAwarePaginator
    {
        /** @var Builder $builder */
        $builder = static::withTrashed();

        if (!empty($search))
            $builder->where('title', 'like', '%' . $search . '%');

        return $builder->orderBy('position', 'desc')->paginate(self::LIMIT);
    }
}
