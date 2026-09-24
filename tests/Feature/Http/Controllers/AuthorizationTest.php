<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
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
