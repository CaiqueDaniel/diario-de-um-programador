<?php

namespace App\Http\Requests\Post;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    public function rules(): array
    {
        $unique = Rule::unique('posts', 'title');

        /** @var Post $post */
        if (!empty($post = $this->route('post')))
            $unique->ignore($post->id);

        $thumbnailRules = ['max:8196', 'mimes:jpg,jpeg,png,webp'];

        if (empty($post))
            $thumbnailRules[] = 'required';

        return [
            'title' => ['required', 'max:255', $unique],
            'subtitle' => ['required', 'max:255'],
            'article' => ['required'],
            'thumbnail' => $thumbnailRules,
            'categories.*' => ['nullable', 'numeric', 'distinct']
        ];
    }
}
