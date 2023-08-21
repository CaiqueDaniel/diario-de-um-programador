<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Services\PostService;
use Illuminate\View\View;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function show(string $slug): View
    {
        $post = $this->postService->getByPermalink($slug);

        return view('pages.web.post.post', compact('post'));
    }
}
