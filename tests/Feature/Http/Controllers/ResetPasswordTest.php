<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
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
     * Test route password email redirect.
     */
    public function test_route_password_email_redirect(): void
    {
        User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
            ]
        );

        $data = [
            'email' => 'ivan@example.com',
        ];

        $response = $this->from(route('password.request'))
            ->post(route('password.email'), $data);

        $response->assertRedirect(route('password.request'));
    }

    /**
     * Test route password email with valid.
     */
    public function test_route_password_email_with_valid(): void
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

        $response->assertSessionHas('status');
    }

    /**
     * Test route password email with errors.
     */
    public function test_route_password_email_with_errors(): void
    {
        User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
            ]
        );

        $data = [
            'email' => 'ivan@exampl.com',
        ];

        $response = $this->post(route('password.email'), $data);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test route password email guests.
     */
    public function test_route_password_email_guests(): void
    {
        User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
            ]
        );

        $data = [
            'email' => 'ivan@example.com',
        ];

        $this->post(route('password.email'), $data);

        $this->assertGuest();
    }

    /**
     * Test route password email throttle.
     *  
     */
    public function test_route_password_email_throttle(): void
    {
        User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
            ]
        );

        $data = [
            'email' => 'ivan@exampl.com',
        ];

        $response1 = $this->from(route('password.request'))
            ->post(route('password.email'), $data);

        $response1->assertRedirect(route('password.request'));

        $response2 = $this->from(route('password.request'))
            ->post(route('password.email'), $data);

        $response2->assertRedirect(route('password.request'));

        $response3 = $this->from(route('password.request'))
            ->post(route('password.email'), $data);

        $response3->assertStatus(429);

        $this->travel(61)->seconds();

        $response4 = $this->from(route('password.request'))
            ->post(route('password.email'), $data);

        $response4->assertRedirect(route('password.request'));
    }

    /**
     * Test route password reset.
     */
    public function test_route_password_reset(): void
    {
        $user = User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
            ]
        );

        $token = Password::createToken($user);

        $response = $this->get(route('password.reset', ['token' => $token]));

        $response->assertStatus(200);
    }

    /**
     * Test route password reset view.
     */
    public function test_route_password_reset_view(): void
    {
        $user = User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
            ]
        );

        $token = Password::createToken($user);

        $response = $this->get(route('password.reset', ['token' => $token]));

        $response->assertViewIs('user.reset-password');
    }

    /**
     * Test route password reset token.
     */
    public function test_route_password_reset_token(): void
    {
        $user = User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
            ]
        );

        $token = Password::createToken($user);

        $response = $this->get(route('password.reset', ['token' => $token]));

        $response->assertSee($token);
    }

    /**
     * Test route password reset guests.
     */
    public function test_route_password_reset_guests(): void
    {
        $user = User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
            ]
        );

        $token = Password::createToken($user);

        $this->get(route('password.reset', ['token' => $token]));

        $this->assertGuest();
    }

    /**
     * Test route password update valid.
     */
    public function test_route_password_update_valid(): void
    {
        $user = User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
            ]
        );

        $token = Password::createToken($user);

        dd($token);

        $response = $this->get(route('password.reset', ['token' => $token]));

        $response->assertSee($token);
    }

    /**
     * Test route password update.
     */
    public function test_route_password_update(): void
    {
        $response = $this->post('/reset-password');

        $response->assertStatus(302);
    }
}
