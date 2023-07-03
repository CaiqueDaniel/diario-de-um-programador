<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    public function show(string $slug): View
    {
        $post = Post::with('author')->where('permalink', 'like', $slug)->first();

        return view('pages.app.post.post', compact('post'));
    }
}
