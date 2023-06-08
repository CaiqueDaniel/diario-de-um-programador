<?php

namespace App\Http\Requests\Get;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search'=>'nullable|string|max:255'
        ];
    }
}
