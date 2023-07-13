<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Get\SearchRequest;
use App\Http\Requests\Post\PostRequest;
use App\Http\Services\PostService;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\View\View;
use App\Models\Post;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(SearchRequest $request): View
    {
        $response = Post::findAll($request->get('search'));

        return view('pages.admin.post.listing', compact('response'));
    }

    public function store(PostRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $this->postService->store($user, $request);

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
