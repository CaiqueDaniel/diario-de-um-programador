<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostRequest;
use App\Http\Services\PostService;
use Cocur\Slugify\Slugify;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\View\View;
use App\Models\{
    Post,
    User
};

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(): View
    {
        $response = Post::findAll();

        return view('pages.admin.post.listing', compact('response'));
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $this->postService->store($request);

        session()->flash('message', 'Artigo criado com sucesso');

        return redirect()->route('admin.post.index');
    }

    public function edit(Post $post): View
    {
        return view('pages.admin.post.form', compact('post'));
    }

    public function update(Post $post, PostRequest $request): RedirectResponse
    {
        $this->postService->update($post, $request);

        session()->flash('message', 'Artigo editado com sucesso');

        return redirect()->route('admin.post.index');
    }

    public function trash(Post $post): Response
    {
        $post->delete();

        return response(null);
    }

    public function restore(Post $post): Response
    {
        $post->restore();

        return response(null);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->postService->destroy($post);

        session()->flash('message', 'Artigo removido com sucesso');

        return redirect()->route('admin.post.index');
    }
}
