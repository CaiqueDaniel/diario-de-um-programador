<?php

namespace App\Http\Requests\Post;

use App\Dtos\Fullbanner\CreateFullbannerDto;
use App\Dtos\Fullbanner\UpdateFullbannerDto;
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

    public function toDto(): CreateFullbannerDto|UpdateFullbannerDto
    {
        if (empty($this->route()->parameter('fullbanner'))) {
            return new CreateFullbannerDto(
                $this->get('title'),
                $this->get('link'),
                $this->file('image')
            );
        }

        return new UpdateFullbannerDto(
            $this->get('title'),
            $this->get('link'),
            $this->file('image')
        );
    }
}
