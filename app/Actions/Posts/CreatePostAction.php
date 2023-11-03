<?php

namespace App\Actions\Posts;

use App\Dtos\Post\PostDto;
use App\Models\Post;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;

class CreatePostAction
{
    public function __construct(private readonly FileUploadService $fileUploadService)
    {
    }

    /** @throws CannotWriteFileException*/
    public function execute(PostDto $dto, User $user): Post
    {
        $post = new Post([
            'title' => $dto->title,
            'subtitle' => $dto->subtitle,
            'article' => $dto->article
        ]);

        $post->setPermalink($dto->title);

        if (!empty($dto->thumbnail))
            $this->uploadThumbnail($post, $dto->thumbnail);

        DB::transaction(function () use ($user, $post, $dto) {
            $user->posts()->save($post);
            $post->categories()->attach($dto->categories);
        });

        return $post;
    }

    /** @throws CannotWriteFileException*/
    private function uploadThumbnail(Post $post, UploadedFile $file): void
    {
        $thumbnail = $this->fileUploadService->upload($file, 'thumbnails');
        $post->setThumbnail($thumbnail);
    }
}
