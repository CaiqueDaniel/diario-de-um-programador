<?php

namespace Tests\Feature;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Silber\Bouncer\Bouncer;
use Tests\Feature\Fixture\WithLoggedSuperAdmin;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithLoggedSuperAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupUserWithSessionByTest($this);
    }

    public function test_load_user_listing_page():void{
        $response = $this->get(route('admin.user.index'));
        $response
            ->assertOk()
            ->assertViewIs('pages.admin.user.listing');
    }

    public function test_load_form_create_admin_user(): void
    {
        $response = $this->get(route('admin.user.create'));
        $response
            ->assertOk()
            ->assertViewIs('pages.admin.user.form');
    }

    public function test_load_form_edit_admin_user(): void
    {
        $userData = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
        ];

        $user = new User($userData);
        $user->setPassword($this->faker->password())->save();

        $this->assertDatabaseHas(User::class, $userData);

        $response = $this->get(route('admin.user.edit', ['user' => $user->getId()]));
        $response
            ->assertOk()
            ->assertViewIs('pages.admin.user.form');
    }

    public function test_create_new_admin_user(): void
    {
        $userData = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
        ];

        $response = $this->post(route('admin.user.store'), $userData);
        $response->assertRedirect(route('admin.user.index'));

        $user = User::query()->where('email', '=', $userData['email'])->first();

        $this->assertTrue(Bouncer::create()->is($user)->an(Roles::ADMIN->name));
        $this->assertDatabaseHas(User::class, $userData);
    }

    public function test_update_admin_user(): void
    {
        $userData = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
        ];

        $user = new User($userData);
        $user->setPassword($this->faker->password())->save();

        $this->assertDatabaseHas(User::class, $userData);

        $userData = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
        ];

        $response = $this->put(route('admin.user.update', ['user' => $user->getId()]), $userData);
        $response->assertRedirect(route('admin.user.index'));

        $this->assertDatabaseHas(User::class, $userData);
    }

    public function test_delete_admin_user(): void
    {
        $userData = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
        ];

        $user = new User($userData);
        $user->setPassword($this->faker->password())->save();

        $this->assertDatabaseHas(User::class, $userData);

        $response = $this->delete(route('admin.user.update', ['user' => $user->getId()]), $userData);
        $response->assertRedirect(route('admin.user.index'));

        $this->assertDatabaseMissing(User::class, $userData);
    }
}
