<?php

namespace App\Actions\Categories;

use App\Dtos\Category\CategoryDto;
use App\Models\Category;

class CreateCategoryAction
{
    public function execute(CategoryDto $categoryDto): Category
    {
        $category = (new Category)->setName($categoryDto->name);

        /** @var Category $parentCategory */
        $parentCategory = Category::query()->find($categoryDto->parent);

        if (empty($parentCategory)) {
            $category->setPermalink($category->getName());
            $category->save();
        } else {
            $category->setPermalink($category->getName(), $parentCategory->getPermalink());
            $parentCategory->children()->save($category);
        }

        return $category;
    }
}
