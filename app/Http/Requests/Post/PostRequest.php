<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'subtitle' => 'required|max:255',
            'article' => 'required',
            'thumbnail' => 'required|max:8196|mimes:jpg,jpeg,png,webp'
        ];
    }
}
