<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Models\User;
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;

class PostService
{
    private const THUMBNAILS_DISK = 'public';
    private const FILLABLE_KEYS = ['title', 'subtitle', 'article'];

    public function store(Request $request): Post
    {
        /** @var User $user */
        $user = auth()->user();
        $post = new Post($request->only(self::FILLABLE_KEYS));

        PostService::definePermalink($post);
        PostService::defineThumbnail($post, $request);

        DB::transaction(function () use ($user, $post, $request) {
            $user->posts()->save($post);
            $post->categories()->attach($request->get('categories'));
        });

        return $post;
    }

    public function update(Post $post, Request $request): Post
    {
        $post->fill($request->only(self::FILLABLE_KEYS));

        PostService::definePermalink($post);
        PostService::defineThumbnail($post, $request);

        DB::transaction(function () use ($post, $request) {
            $post->save();
            $post->categories()->sync($request->get('categories'));
        });

        return $post;
    }

    public function destroy(Post $post): void
    {
        $post->forceDelete();

        PostService::deleteUnusedThumbnail($post);
    }

    private static function definePermalink(Post $post): void
    {
        $slugfy = new Slugify();
        $post->permalink = $slugfy->slugify($post->title);
    }

    private static function defineThumbnail(Post $post, Request $request): void
    {
        $REQUEST_KEY = 'thumbnail';
        $PUBLIC_THUMBNAIL_PATH = 'thumbnails';

        $file = $request->file($REQUEST_KEY);

        if (empty($file))
            return;

        $newThumbnail = $file->storePublicly($PUBLIC_THUMBNAIL_PATH, self::THUMBNAILS_DISK);

        if (empty($newThumbnail))
            throw new CannotWriteFileException();

        PostService::deleteUnusedThumbnail($post);

        $post->thumbnail = $newThumbnail;
    }

    private static function deleteUnusedThumbnail(Post $post): void
    {
        if (empty($post->thumbnail))
            return;

        Storage::disk(self::THUMBNAILS_DISK)->delete($post->thumbnail);
    }
}
