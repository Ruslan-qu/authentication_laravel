<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    /**
     * Test route password request.
     */
    public function test_route_password_request(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    /**
     * Test route password email.
     */
    public function test_route_password_email(): void
    {
        $response = $this->post('/forgot-password');

        $response->assertStatus(302);
    }

    /**
     * Test route password_reset.
     */
    public function test_route_password_reset(): void
    {
        $response = $this->get('/reset-password/{token}');

        $response->assertStatus(200);
    }

    /**
     * Test route password.update.
     */
    public function test_route_password_update(): void
    {
        $response = $this->post('/reset-password');

        $response->assertStatus(302);
    }
}
