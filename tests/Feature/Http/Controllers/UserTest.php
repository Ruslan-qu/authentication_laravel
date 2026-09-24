<?php

namespace Tests\Feature\Http\Controllers;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserTest extends TestCase
{

    /**
     * Test route home.
     */
    public function test_route_home(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }

    /**
     * Test route home view.
     *  
     */
    public function test_route_home_view(): void
    {

        $response = $this->get(route('home'));

        $response->assertViewIs('welcome');
    }

    /**
     * Test route register.
     */
    public function test_route_register(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    /**
     * Test route register view.
     *  
     */
    public function test_route_register_view(): void
    {

        $response = $this->get(route('register'));

        $response->assertViewIs('user.create');
    }

    /**
     * Test route user guests.
     */
    public function test_route_user_guests(): void
    {

        $response = $this->post(route('user.store'));

        $this->assertGuest();
    }

    /**
     * Test route user store invalid.
     */
    public function test_route_user_store_invalid(): void
    {

        $user = [
            'name' => '',
            'email' => 'ivan.com',
            'password' => 'pass',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('user.store'), $user);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /**
     * Test route user store valid.
     */
    public function test_route_user_store_valid(): void
    {

        $user = [
            'name' => 'Иван',
            'email' => 'ivan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('user.store'), $user);

        $response->assertValid();
    }

    /**
     * Test route user store creates.
     */
    public function test_route_user_store_creates(): void
    {

        $user = [
            'name' => 'Иван',
            'email' => 'ivan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('user.store'), $user);

        $this->assertDatabaseHas('users', [
            'email' => 'ivan@example.com',
            'name' => 'Иван',
        ]);
    }

    /**
     * Test route user store event.
     */
    public function test_route_user_store_event(): void
    {
        Event::fake();

        $user = [
            'name' => 'Иван',
            'email' => 'ivan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('user.store'), $user);

        Event::assertDispatched(Registered::class);
    }

    /**
     * Test route user store auth.
     */
    public function test_route_user_store_auth(): void
    {

        $user = [
            'name' => 'Иван',
            'email' => 'ivan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('user.store'), $user);

        $this->assertAuthenticatedAs(User::where('email', '=', 'ivan@example.com', '')->first());
    }

    /**
     * Test route register user store.
     */
    public function test_route_register_user_store(): void
    {
        $user = [
            'name' => 'Иван',
            'email' => 'ivan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('user.store'), $user);

        $response->assertRedirect(route('verification.notice'));
    }
}
