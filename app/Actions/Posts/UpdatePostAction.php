<?php

namespace App\Actions\Posts;

use App\Dtos\Post\PostDto;
use App\Models\Post;
use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UpdatePostAction
{
    public function __construct(private readonly FileUploadService $fileUploadService)
    {
    }

    public function execute(PostDto $dto, Post $post): Post
    {
        $post->fill([
            'title' => $dto->title,
            'subtitle' => $dto->subtitle,
            'article' => $dto->article
        ]);

        $post->setPermalink($dto->title);

        if (!empty($dto->thumbnail))
            $this->uploadThumbnail($post, $dto->thumbnail);

        DB::transaction(function () use ($post, $dto) {
            $post->save();
            $post->categories()->sync($dto->categories);
        });

        return $post;
    }

    private function uploadThumbnail(Post $post, UploadedFile $file): void
    {
        $thumbnail = $this->fileUploadService->upload($file, 'thumbnails');

        if (!empty($post->thumbnail))
            $this->fileUploadService->delete($post->thumbnail);

        $post->setThumbnail($thumbnail);
    }
}
