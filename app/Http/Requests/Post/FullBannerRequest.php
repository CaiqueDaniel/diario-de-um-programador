<?php

namespace App\Http\Requests\Post;

use App\Dtos\Fullbanner\FullbannerDto;
use Illuminate\Foundation\Http\FormRequest;

class FullBannerRequest extends FormRequest
{
    public function rules(): array
    {
        $imageRules = ['max:8196', 'mimes:jpg,jpeg,png,webp'];

        if (empty($this->route()->parameter('fullbanner')))
            $imageRules[] = 'required';

        return [
            'title' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:255'],
            'image' => $imageRules
        ];
    }

    public function toDto(): FullbannerDto
    {
        return new FullbannerDto(
            $this->get('title'),
            $this->get('link'),
            $this->file('image')
        );
    }
}
