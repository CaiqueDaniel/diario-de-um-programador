<?php

namespace App\Http\Requests\Post;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        $unique = Rule::unique('categories', 'name');

        /** @var Category $category */
        if (!empty($category = $this->route('category')))
            $unique->ignore($category->id);

        return [
            'name' => ['required', 'string', 'max:255', $unique],
            'parent' => ['numeric', 'nullable']
        ];
    }
}
