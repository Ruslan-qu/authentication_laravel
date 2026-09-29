<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    /**
     * Test route login.
     */
    public function test_route_login(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    /**
     * Test route login view.
     *  
     */
    public function test_route_login_view(): void
    {

        $response = $this->get(route('login'));

        $response->assertViewIs('user.login');
    }

    /**
     * Test route login guests.
     */
    public function test_route_login_guests(): void
    {

        $response = $this->post(route('login'));

        $this->assertGuest();
    }

    /**
     * Test route authorization user invalid.
     */
    public function test_route_authorization_user_invalid(): void
    {

        $user = [
            'email' => 'ivan.com',
            'password' => '',
        ];

        $response = $this->post(route('login'), $user);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    /**
     * Test route authorization user valid.
     */
    public function test_route_authorization_user_valid(): void
    {

        User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
                'password' => 'password123',
            ]
        );

        $user = [
            'email' => 'ivan@example.com',
            'password' => 'password123',
        ];

        $response = $this->post(route('login'), $user);

        $response->assertValid();
    }

    /**
     * Test route authorization user authenticate session.
     */
    public function test_route_authorization_user_authenticate_session(): void
    {

        User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
                'password' => 'password123',
            ]
        );

        $data = [
            'email' => 'ivan@example.com',
            'password' => 'password123',
        ];

        $sessionId = Session::getId();

        $response = $this->post(route('login'), $data);

        $newSessionId = $response->getSession()->getId();

        $this->assertNotEquals($sessionId, $newSessionId);
    }

    /**
     * Test route authorization user authenticate.
     */
    public function test_route_authorization_user_authenticate(): void
    {

        $user = User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
                'password' => 'password123',
            ]
        );

        $data = [
            'email' => 'ivan@example.com',
            'password' => 'password123',
        ];

        $response = $this->post(route('login'), $data);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test route authorization user authenticate remember.
     */
    public function test_route_authorization_user__authenticate_remember(): void
    {

        $user = User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
                'password' => 'password123',
            ]
        );

        $data = [
            'email' => 'ivan@example.com',
            'password' => 'password123',
            'remember' => 'on',
        ];

        $response = $this->post(route('login'), $data);

        $response->assertCookie(Auth::getRecallerName());
    }

    /**
     * Test route authorization user authenticate redirect.
     */
    public function test_route_authorization_user_authenticate_redirect(): void
    {

        $user = User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
                'password' => 'password123',
            ]
        );

        $data = [
            'email' => 'ivan@example.com',
            'password' => 'password123',
        ];

        $response = $this->post(route('login'), $data);

        $response->assertRedirect(route('user.dashboard', ['user' => $user]));
    }

    /**
     * Test route authorization user message.
     */
    public function test_route_authorization_user_message(): void
    {
        $user = User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
                'password' => 'password123',
            ]
        );

        $data = [
            'email' => 'ivan@exampl.com',
            'password' => 'password12',
        ];

        $response = $this->post(route('login'), $data);

        $response->assertSessionHas('errorAuthorization', 'Указанные учетные данные не соответствуют.');
    }

    /**
     * Test route authorization user invalid attempt.
     */
    public function test_route_authorization_user_invalid_attempt(): void
    {
        $user = User::factory()->verified()->create(
            [
                'email' => 'ivan@example.com',
                'password' => 'password123',
            ]
        );

        $data = [
            'email' => 'ivan@exampl.com',
            'password' => 'password12',
        ];

        $response = $this->post(route('login'), $data);

        $response->assertRedirect(route('login'));
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
