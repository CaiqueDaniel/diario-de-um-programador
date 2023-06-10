<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CategoryRequest;
use App\Models\Category;
use App\Models\Post;
use Cocur\Slugify\Slugify;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    private const FILLABLE_KEYS = ['name'];

    public function index(): View
    {
        $items = Category::withTrashed()->get();

        return view('pages.admin.category.listing', compact('items'));
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $slugfy = new Slugify();
        $category = new Category($request->only(self::FILLABLE_KEYS));

        /** @var Category $parentCategory */
        $parentCategory = Category::find($request->get('parent'));

        if (empty($parentCategory)) {
            $category->permalink = $slugfy->slugify($category->name);
            $category->save();
        } else {
            $category->permalink = "{$parentCategory->permalink}/{$slugfy->slugify($category->name)}";
            $parentCategory->children()->save($category);
        }

        session()->flash('message', 'Categoria criada com sucesso');

        return redirect()->route('admin.category.index');
    }

    public function edit(Category $category): View
    {
        return view('pages.admin.category.form', compact('category'));
    }

    public function update(Category $category, CategoryRequest $request): RedirectResponse
    {
        $slugfy = new Slugify();
        $category->fill($request->only(self::FILLABLE_KEYS));

        /** @var Category $parentCategory */
        $parentCategory = Category::find($request->get('parent'));

        if (empty($parentCategory)) {
            $parentCategory = $category->parent()->first();

            if (!empty($parentCategory))
                $category->parent()->disassociate();

            $category->permalink = $slugfy->slugify($category->name);
            $category->save();
        } else {
            $category->permalink = "{$parentCategory->permalink}/{$slugfy->slugify($category->name)}";
            $parentCategory->children()->save($category);
        }

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
