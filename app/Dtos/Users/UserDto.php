<?php

namespace App\Dtos\Users;

use Illuminate\Contracts\Support\Arrayable;

class UserDto implements Arrayable
{
    public function __construct(
        private readonly string  $name,
        private readonly string  $email,
        private readonly ?string $password = null
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
