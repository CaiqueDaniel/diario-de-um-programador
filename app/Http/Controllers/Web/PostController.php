<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    public function show(string $slug): View
    {
        $post = Post::with('author')
            ->where('permalink', 'like', $slug)
            ->whereNotNull('published_at')
            ->first();

        return view('pages.web.post.post', compact('post'));
    }
}
