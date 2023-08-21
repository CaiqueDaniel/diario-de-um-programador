<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\{Post, User};
use Cocur\Slugify\Slugify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostService
{
    private const FILLABLE_KEYS = ['title', 'subtitle', 'article'];
    private const FILE_KEY = 'thumbnail';
    private const PUBLIC_THUMBNAIL_PATH = 'thumbnails';

    private FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function store(User $user, Request $request): Post
    {
        $post = new Post($request->only(self::FILLABLE_KEYS));

        $this->definePermalink($post);
        $this->defineThumbnail($post, $request);

        DB::transaction(function () use ($user, $post, $request) {
            $user->posts()->save($post);
            $post->categories()->attach($request->get('categories'));
        });

        return $post;
    }

    public function update(Post $post, Request $request): Post
    {
        $post->fill($request->only(self::FILLABLE_KEYS));

        $this->definePermalink($post);
        $this->defineThumbnail($post, $request);

        DB::transaction(function () use ($post, $request) {
            $post->save();
            $post->categories()->sync($request->get('categories'));
        });

        return $post;
    }

    public function destroy(Post $post): void
    {
        $post->forceDelete();

        $this->fileUploadService->delete($post->getThumbnail());
    }

    /**
     * @throw ModelNotFoundException
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

    private function definePermalink(Post $post): void
    {
        $slugfy = new Slugify();
        $post->setPermalink($slugfy->slugify($post->getTitle()));
    }

    private function defineThumbnail(Post $post, Request $request): void
    {
        $file = $request->file(self::FILE_KEY);

        if (empty($file))
            return;

        $thumbnail = $this->fileUploadService->upload($file, self::PUBLIC_THUMBNAIL_PATH);

        if (!empty($post->thumbnail))
            $this->fileUploadService->delete($post->thumbnail);

        $post->setThumbnail($thumbnail);
    }
}
