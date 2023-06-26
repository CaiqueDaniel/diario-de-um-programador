<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class FullBannerRequest extends FormRequest
{
    public function rules(): array
    {
        $imageRules = ['max:8196', 'mimes:jpg,jpeg,png,webp'];

        if (empty($post))
            $imageRules[] = 'required';

        return [
            'title' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            'image' => $imageRules
        ];
    }
}
