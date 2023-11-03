<?php

namespace App\Http\Controllers\Web;

use App\Actions\Posts\GetPostByPermalinkAction;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PostController extends Controller
{
    public function show(string $slug, GetPostByPermalinkAction $getPostByPermalink): View
    {
        $post = $getPostByPermalink->execute($slug);

        return view('pages.web.post.post', compact('post'));
    }
}
