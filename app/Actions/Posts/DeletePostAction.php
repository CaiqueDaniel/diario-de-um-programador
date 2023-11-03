<?php

namespace App\Actions\Posts;

use App\Models\Post;
use App\Services\FileUploadService;

class DeletePostAction
{
    public function __construct(private readonly FileUploadService $fileUploadService)
    {
    }

    public function execute(Post $post): void
    {
        if (!empty($post->getThumbnail()))
            $this->fileUploadService->delete($post->getThumbnail());

        $post->forceDelete();
    }
}
