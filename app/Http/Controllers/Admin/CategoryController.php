<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Get\SearchRequest;
use App\Http\Requests\Post\CategoryRequest;
use App\Models\Category;
use Cocur\Slugify\Slugify;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    private const FILLABLE_KEYS = ['name'];

    public function index(SearchRequest $request): View
    {
        $items = Category::findAll($request->get('search'));

        return view('pages.admin.category.listing', compact('items'));
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $slugfy = new Slugify();
        $category = new Category($request->only(self::FILLABLE_KEYS));

        /** @var Category $parentCategory */
        $parentCategory = Category::query()->find($request->get('parent'));

        if (empty($parentCategory)) {
            $category->setPermalink($slugfy->slugify($category->getName()));
            $category->save();
        } else {
            $category->setPermalink("{$parentCategory->getPermalink()}/{$slugfy->slugify($category->getName())}");
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
        $parentCategory = Category::query()->find($request->get('parent'));

        if (empty($parentCategory)) {
            $parentCategory = $category->parent()->first();

            if (!empty($parentCategory))
                $category->parent()->disassociate();

            $category->setPermalink($slugfy->slugify($category->getName()));
            $category->save();
        } else {
            $category->setPermalink("{$parentCategory->getPermalink()}/{$slugfy->slugify($category->getName())}");
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
