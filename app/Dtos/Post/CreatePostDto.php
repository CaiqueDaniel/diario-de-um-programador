<?php

namespace App\Dtos\Post;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\UploadedFile;

class CreatePostDto implements Arrayable
{
    public function __construct(
        public readonly string $title,
        public readonly string $article,
        public readonly ?string $subtitle = null,
        public readonly ?UploadedFile $thumbnail = null,
        /** @var int[] */
        public readonly array $categories = [],
    ) {
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'article' => $this->article,
            'thumbnail' => $this->thumbnail,
            'categories' => $this->categories
        ];
    }
}
