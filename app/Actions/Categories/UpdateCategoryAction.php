<?php

namespace App\Actions\Categories;

use App\Dtos\Category\CategoryDto;
use App\Models\Category;

class UpdateCategoryAction
{
    public function execute(CategoryDto $categoryDto, Category $category): Category
    {
        $category->setName($categoryDto->name);

        /** @var Category $parentCategory */
        $parentCategory = Category::query()->find($categoryDto->parent);

        if (empty($parentCategory)) {
            $parentCategory = $category->parent()->first();

            if (!empty($parentCategory))
                $category->parent()->disassociate();

            $category->setPermalink($category->getName());
            $category->save();
        } else {
            $category->setPermalink($category->getName(), $parentCategory->getPermalink());
            $parentCategory->children()->save($category);
        }

        return $category;
    }
}
