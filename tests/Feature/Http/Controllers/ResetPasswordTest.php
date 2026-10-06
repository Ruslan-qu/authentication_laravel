<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    /**
     * Test route password request.
     */
    public function test_route_password_request(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
    }

    /**
     * Test route password request view.
     *  
     */
    public function test_route_password_request_view(): void
    {

        $response = $this->get(route('password.request'));

        $response->assertViewIs('user.forgot-password');
    }

    /**
     * Test route password request guests.
     */
    public function test_route_password_request_guests(): void
    {

        $this->post(route('password.request'));

        $this->assertGuest();
    }

    /**
     * Test route password email invalid.
     */
    public function test_route_password_email_invalid(): void
    {

        $data = [
            'email' => 'ivan.com',
        ];

        $response = $this->post(route('password.email'), $data);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test route password email valid.
     */
    public function test_route_password_email_valid(): void
    {
        User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
            ]
        );

        $data = [
            'email' => 'ivan@example.com',
        ];

        $response = $this->post(route('password.email'), $data);

        $response->assertValid();
    }

    /**
     * Test route password email status invalid.
     */
    public function test_route_password_email_status_invalid(): void
    {
        Notification::fake();

        User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
            ]
        );

        $data = [
            'email' => 'ivan@exampl.com',
        ];

        $response = $this->post(route('password.email'), $data);

        Notification::assertNothingSent();
    }

    /**
     * Test route password email status valid.
     */
    public function test_route_password_email_status_valid(): void
    {
        Notification::fake();

        $user = User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
            ]
        );

        $data = [
            'email' => 'ivan@example.com',
        ];

        $this->post(route('password.email'), $data);

        Notification::assertSentTo(
            [$user],
            ResetPassword::class
        );
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
