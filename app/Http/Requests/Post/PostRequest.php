<?php

namespace App\Http\Requests\Post;

use App\Dtos\Post\PostDto;
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
            $unique->ignore($post->getId());

        $thumbnailRules = ['max:8196', 'mimes:jpg,jpeg,png,webp'];

        return [
            'title' => ['required', 'max:255', $unique],
            'subtitle' => ['max:255'],
            'article' => ['required'],
            'thumbnail' => $thumbnailRules,
            'categories.*' => ['nullable', 'numeric', 'distinct']
        ];
    }

    public function toDto(): PostDto
    {
        return new PostDto(
            $this->get('title'),
            $this->get('article'),
            $this->get('subtitle'),
            $this->file('thumbnail'),
            $this->get('categories') ?? [],
        );
    }
}
