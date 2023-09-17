<?php

namespace App\Models;

use Carbon\Carbon;
use Cocur\Slugify\Slugify;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\{Model, Builder, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

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

    /**
     * @throws Throwable
     */
    public function publish(): void
    {
        if ($this->isPublished())
            return;

        $this->setPublishedAt(Carbon::now())->saveOrFail();
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getTitle(): string
    {
        return $this->attributes['title'];
    }

    public function getSubtitle(): string
    {
        return $this->attributes['subtitle'];
    }

    public function getArticle(): string
    {
        return $this->attributes['article'];
    }

    public function getPermalink(): string
    {
        return $this->attributes['permalink'];
    }

    public function getThumbnail(): string
    {
        return $this->attributes['thumbnail'];
    }

    public function isPublished(): bool
    {
        return !empty($this->getPublishedAt());
    }

    public function getPublishedAt(): ?DateTime
    {
        $publishedAt = $this->attributes['published_at'] ?? null;

        if (empty($publishedAt))
            return null;

        return new Carbon($publishedAt);
    }

    public function getCategories(): Collection
    {
        if (empty($this->categories))
            $this->categories = $this->categories()->get();

        return $this->categories;
    }

    public function getAuthor(): User
    {
        /** @var User */
        return $this->author()->firstOrFail();
    }

    public function setTitle(string $value): self
    {
        $this->attributes['title'] = $value;
        return $this;
    }

    public function setSubtitle(string $value): self
    {
        $this->attributes['subtitle'] = $value;
        return $this;
    }

    public function setArticle(string $value): self
    {
        $this->attributes['article'] = $value;
        return $this;
    }

    public function setPermalink(string $value): self
    {
        $slugfy = new Slugify();

        $this->attributes['permalink'] = $slugfy->slugify($value);
        return $this;
    }

    public function setThumbnail(string $value): self
    {
        $this->attributes['thumbnail'] = $value;
        return $this;
    }

    private function setPublishedAt(DateTime $value): self
    {
        $this->attributes['published_at'] = $value->format('Y-m-d H:i:s');
        return $this;
    }

    public static function findAll(string $search = null): LengthAwarePaginator
    {
        /** @var Builder $builder */
        $builder = static::withTrashed();

        if (!empty($search))
            $builder->where('title', 'like', '%' . $search . '%');

        return $builder->with('author')->orderBy('id', 'desc')->paginate(self::LIMIT);
    }

    public static function findAllByAuthor(User $user, string $search = null): LengthAwarePaginator
    {
        /** @var Builder $builder */
        $builder = static::withTrashed()->where('author', '=', $user->getId());

        if (!empty($search))
            $builder->where('title', 'like', '%' . $search . '%');

        return $builder->with('author')->orderBy('id', 'desc')->paginate(self::LIMIT);
    }

    public static function findAllWithoutTrashed(string $search = null): LengthAwarePaginator
    {
        $builder = static::query()->whereNotNull('published_at');

        if (!empty($search))
            $builder->where('title', 'like', '%' . $search . '%');

        return $builder->with('author')->orderBy('id', 'desc')->paginate(self::LIMIT);
    }

    public static function findAllWithoutTrashedByCategory(Category $category): LengthAwarePaginator
    {
        return $category
            ->posts()
            ->whereNotNull('published_at')
            ->orderBy('id', 'desc')
            ->paginate(self::LIMIT);
    }
}
