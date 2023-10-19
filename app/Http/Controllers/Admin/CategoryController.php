<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Categories\{CreateCategoryAction, UpdateCategoryAction};
use App\Http\Controllers\Controller;
use App\Http\Requests\Get\SearchRequest;
use App\Http\Requests\Post\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index(SearchRequest $request): View
    {
        $items = Category::findAll($request->get('search'));

        return view('pages.admin.category.listing', compact('items'));
    }

    public function store(CategoryRequest $request, CreateCategoryAction $createCategory): RedirectResponse
    {
        $createCategory->execute($request->toDto());

        session()->flash('message', 'Categoria criada com sucesso');

        return redirect()->route('admin.category.index');
    }

    public function edit(Category $category): View
    {
        return view('pages.admin.category.form', compact('category'));
    }

    public function update(Category $category, CategoryRequest $request, UpdateCategoryAction $updateCategory): RedirectResponse
    {
        $updateCategory->execute($request->toDto(), $category);

        session()->flash('message', 'Categoria editada com sucesso');

        return redirect()->route('admin.category.index');
    }

    public function trash(Category $category): Response
    {
        $category->delete();

        return response(null);
    }

    public function restore(Category $category): Response
    {
        $category->restore();

        return response(null);
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->forceDelete();

        session()->flash('message', 'Categoria excluída com sucesso');

        return redirect()->route('admin.category.index');
    }
}
