<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_register_user(): void
    {
        $response = $this->post('register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'user' => [
                        'name',
                        'email',
                    ],
                ],
                'message',
                'success',
            ]);
    }

    public function test_cant_register_user_with_not_valid_data(): void
    {
        $response = $this->post('register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password1',
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
    }
}
