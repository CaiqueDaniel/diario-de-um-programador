<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\{
    Post,
    User
};

class PostController extends Controller
{
    public function index(): View
    {
        $response = Post::findAll();

        return view('pages.admin.post.listing', compact('response'));
    }

    public function store(PostRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $post = new Post($request->validated());

        $user->posts()->save($post);

        session()->flash('message', 'Artigo criado com sucesso');

        return redirect()->route('admin.post.index');
    }

    public function edit(Post $post): View
    {
        return view('pages.admin.post.form', compact('post'));
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $post->fill($request->validated())->saveOrFail();

        session()->flash('message', 'Artigo editado com sucesso');

        return redirect()->route('admin.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
