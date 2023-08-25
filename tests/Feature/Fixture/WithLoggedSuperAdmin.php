<?php

namespace Tests\Feature\Fixture;

use App\Enums\Roles;
use App\Models\User;
use Database\Seeders\LaravelBouncerSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Silber\Bouncer\Bouncer;
use Tests\TestCase;

trait WithLoggedSuperAdmin
{
    use WithFaker, DatabaseMigrations;

    protected User $user;

    public function setupUserWithSessionByTest(TestCase $test): void
    {
        $this->seed(LaravelBouncerSeeder::class);

        $this->user = new User([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
        ]);

        $this->user->setPassword('123456');
        $this->user->save();

        $bouncer = Bouncer::create();

        $bouncer->assign(Roles::SUPER_ADMIN->name)->to($this->user);

        $test->post('/login', [
            'email' => $this->user->getEmail(),
            'password' => '123456'
        ]);
    }
}
