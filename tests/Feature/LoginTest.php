<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->migrateFreshUsing();

        $this->user = new User([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => Hash::make('123456'),
        ]);

        $this->user->save();
    }

    public function test_loading_login(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
    }

    public function test_do_login(): void
    {
        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => '123456'
        ]);

        $response->assertRedirect();

        $this->assertAuthenticatedAs($this->user);
    }

    public function test_wrong_email_on_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'wrongemail.gmail.com',
            'password' => '12345'
        ]);

        $response->assertRedirect()->assertInvalid(['email']);

        $this->assertFalse($this->isAuthenticated());
    }

    public function test_required_email_on_login(): void
    {
        $response = $this->post('/login', ['email' => '', 'password' => '12345']);
        $response->assertRedirect()->assertInvalid(['email']);

        $response = $this->post('/login', ['password' => '12345']);
        $response->assertRedirect()->assertInvalid(['email']);

        $this->assertFalse($this->isAuthenticated());
    }

    public function test_invalid_email_on_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'wrongemail.gmail.com',
            'password' => '12345'
        ]);

        $response->assertRedirect()->assertInvalid(['email']);

        $this->assertFalse($this->isAuthenticated());
    }

    public function test_wrong_password_on_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'wrongemail',
            'password' => '12345'
        ]);

        $response->assertRedirect()->assertInvalid(['email']);

        $this->assertFalse($this->isAuthenticated());
    }

    public function test_required_password_on_login(): void
    {
        $response = $this->post('/login', ['email' => $this->user->email, 'password' => '']);
        $response->assertRedirect()->assertInvalid(['password']);

        $response = $this->post('/login', ['email' => $this->user->email]);
        $response->assertRedirect()->assertInvalid(['password']);

        $this->assertFalse($this->isAuthenticated());
    }
}
