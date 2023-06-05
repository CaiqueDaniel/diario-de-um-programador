<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CategoryRequest;
use App\Models\Category;
use Cocur\Slugify\Slugify;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    private const FILLABLE_KEYS = ['name'];

    public function index(): View
    {
        $items = Category::all();

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

        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
