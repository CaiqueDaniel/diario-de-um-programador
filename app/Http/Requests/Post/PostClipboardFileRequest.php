<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostClipboardFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required|max:8196|mimes:jpg,jpeg,png,webp'
        ];
    }
}
