<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Fixture\WithLoggedSuperAdmin;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithLoggedSuperAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupUserWithSessionByTest($this);
    }

    public function test_when_access_account_page_it_should_load_correct_view(): void
    {
        $response = $this->get(route('admin.account.edit'));

        $response
            ->assertOk()
            ->assertViewIs('pages.admin.account.form');
    }

    public function test_when_send_edited_account_data_it_should_update_user_on_database(): void
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

        $response = $this->put(route('admin.account.update', ['user' => $user->getId()]), $userData);
        $response->assertRedirect(route('admin.account.edit'));

        $this->assertDatabaseHas(User::class, $userData);
    }
}
