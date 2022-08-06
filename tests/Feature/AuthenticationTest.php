<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test that a user can register.
     *
     * @return void
     */
    public function testSuccessfulRegistration()
    {
        $userData = [
            "first_name" => "John",
            "last_name" => "Doe",
            "email" => "doe@example.com",
            "password" => "demo12345",
        ];

        $this->json('POST', 'api/v1/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201);
    }

     /**
     * Test that a user cannot register without an email.
     *
     * @return void
     */
    public function testEmailIsRequiredForRegistration()
    {
        $userData = [
            "first_name" => "John",
            "last_name" => "Doe",
            "password" => "demo12345",
        ];
        $this->json('POST', 'api/v1/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422);
    }

    /**
     * Test that a user can login.
     *
     * @return void
     */
    public function testSuccessfulLogin()
    {
        $userData = [
            "email" => "doe@example.com",
            "password" => "demo12345",
        ];

        $this->json('POST', 'api/v1/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

    /**
     * Test that authenticated routes are protected.
     *
     * @return void
     */
    public function testAuthenticatedRoutesAreProtected()
    {
        $this->json('GET', 'api/v1/user', [], ['Accept' => 'application/json'])
            ->assertStatus(401);
    }

    /**
     * Test that authenticated users can access protected route
     *
     * @return void
     */
    public function testAuthenticatedUsersCanAccessProtectedRoute()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $this->json('GET', 'api/v1/user', [], ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
}
