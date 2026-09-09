<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    /**
     * Test route login.
     */
    public function test_route_login(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Test route authorization user.
     */
    public function test_route_authorization_user(): void
    {
        $response = $this->post('/login');

        $response->assertStatus(302);
    }

    /**
     * Test route logout.
     */
    public function test_route_logout(): void
    {
        
        $response = $this->get('/logout');

        $response->assertRedirect('/login');
    }
}
