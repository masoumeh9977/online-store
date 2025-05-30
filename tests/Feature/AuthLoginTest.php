<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'customer']);
        Role::create(['name' => 'admin']);

        $this->user = User::factory()->create([
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->user->assignRole('customer');
    }

    public function test_user_login_with_correct_credentials_and_customer_role()
    {

        // Act
        $response = $this->post(route('website.login'), [
            'email' => $this->user->email,
            'password' => 'password123'
        ]);

        // Assert
        $response->assertRedirect(route('website.index'));
        $this->assertAuthenticatedAs($this->user);
    }

    public function test_login_fails_with_invalid_email()
    {
        // Act
        $response = $this->post(route('website.login'), [
            'email' => 'wrong@example.com',
            'password' => 'password123'
        ]);

        // Assert
        $response->assertRedirect();
        $this->assertGuest();
    }

    public function test_login_fails_with_wrong_password()
    {
        $response = $this->post(route('website.login'), [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect();
        $this->assertGuest();
    }

    public function test_login_fails_with_non_customer_role()
    {
        $this->user->assignRole('admin');
        $response = $this->post(route('website.login'), [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect();
        $this->assertGuest();
    }
}

