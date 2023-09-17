<?php

namespace Tests\Feature\Fixture;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

trait WithUserFactory
{
    use WithFaker;

    public function factoryUser(): User
    {
        $user = new User([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
        ]);

        return $user->setPassword('123456');
    }
}
