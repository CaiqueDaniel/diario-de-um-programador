<?php

namespace App\Dtos\Fullbanner;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\UploadedFile;

class FullbannerDto implements Arrayable
{
    public function __construct(
        public readonly string       $title,
        public readonly string       $link,
        public readonly UploadedFile $image
    )
    {
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'link' => $this->link,
            'image' => $this->image
        ];
    }
}
