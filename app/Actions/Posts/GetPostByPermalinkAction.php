<?php

namespace App\Actions\Posts;

use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetPostByPermalinkAction
{
    public function execute(string $permalink): Post
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
