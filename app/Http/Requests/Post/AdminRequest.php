<?php

namespace App\Http\Requests\Post;

use App\Dtos\Users\UserDto;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
    public function rules(): array
    {
        $unique = Rule::unique('users', 'email');

        /** @var User $user */
        if (!empty($user = $this->route('user')))
            $unique->ignore($user->getId());

        return [
            'email' => ['required', 'email', $unique, 'max:255'],
            'name' => ['required', 'string', 'max:255']
        ];
    }

    public function toDto(): UserDto
    {
        return new UserDto(
            $this->get('name'),
            $this->get('email')
        );
    }
}
