<?php

namespace App\Http\Requests\Post;

use App\Models\Category;
use App\Rules\WithoutOwnId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        $unique = Rule::unique('categories', 'name');
        $withoutOwnId = new WithoutOwnId();

        /** @var Category $category */
        if (!empty($category = $this->route('category'))) {
            $unique->ignore($category->id);

            $withoutOwnId = new WithoutOwnId($category->id, ((int)$this->request->get('parent')));
        }

        return [
            'name' => ['required', 'string', 'max:255', $unique],
            'parent' => ['numeric', 'nullable', $withoutOwnId]
        ];
    }
}
