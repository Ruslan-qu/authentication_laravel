<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    /**
     * Test route verification notice.
     */
    public function test_route_verification_notice(): void
    {
        $response = $this->get('/email/verify');

        $response->assertStatus(200);
    }

    /**
     * Test route verification send.
     */
    public function test_route_verification_send(): void
    {
        $response = $this->post('/email/verification-notification');

        $response->assertStatus(302);
    }

    /**
     * Test route verification verify.
     */
    public function test_route_verification_verify(): void
    {
        $response = $this->get('/email/verify/{id}/{hash}');

        $response->assertRedirect('/user/dashboard/{user}');
    }
}
