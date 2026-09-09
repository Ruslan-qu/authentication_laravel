<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test route home.
     */
    public function test_route_home(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test route register.
     */
    public function test_route_register(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * Test route register user store.
     */
    public function test_route_register_user_store(): void
    {
        $response = $this->post('/register');

        $response->assertStatus(302);
    }
}
