<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Posts\ListPaginatedPostsByUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Get\SearchRequest;
use App\Http\Requests\Post\PostRequest;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(SearchRequest $request, ListPaginatedPostsByUserAction $listPaginatedPostsByUserAction): View
    {
        /** @var User $user */
        $user = auth()->user();
        $response = $listPaginatedPostsByUserAction->execute($user, $request->get('search'));

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
