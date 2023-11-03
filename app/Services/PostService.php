<?php

namespace App\Services;

use App\Models\{Post};
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostService
{
    private FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByPermalink(string $permalink): Post
    {
        /** @var Post $post */
        $post = Post::with('author')
            ->with('categories')
            ->where('permalink', 'like', $permalink)
            ->whereNotNull('published_at')
            ->first();

        if (empty($post))
            throw new ModelNotFoundException();

        return $post;
    }
}
