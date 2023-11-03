<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Posts\{CreatePostAction, UpdatePostAction, DeletePostAction, ListPaginatedPostsByUserAction};
use App\Models\{Post, User};
use App\Http\Controllers\Controller;
use App\Http\Requests\Get\SearchRequest;
use App\Http\Requests\Post\PostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index(SearchRequest $request, ListPaginatedPostsByUserAction $listPaginatedPostsByUserAction): View
    {
        /** @var User $user */
        $user = auth()->user();
        $response = $listPaginatedPostsByUserAction->execute($user, $request->get('search'));

        return view('pages.admin.post.listing', compact('response'));
    }

    public function store(PostRequest $request, CreatePostAction $createPost): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $createPost->execute($request->toDto(), $user);

        session()->flash('message', __('Article successfully created'));

        return redirect()->route('admin.post.index');
    }

    public function edit(Post $post): View
    {
        return view('pages.admin.post.form', compact('post'));
    }

    public function update(Post $post, PostRequest $request, UpdatePostAction $updatePost): RedirectResponse
    {
        $updatePost->execute($request->toDto(), $post);

        session()->flash('message', __('Article successfully updated'));

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

    public function destroy(Post $post, DeletePostAction $deletePost): RedirectResponse
    {
        $deletePost->execute($post);

        session()->flash('message', __('Article successfully deleted'));

        return redirect()->route('admin.post.index');
    }
}
