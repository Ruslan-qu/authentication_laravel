<?php

namespace Tests\Feature\Http\Controllers;

// use Illuminate\Foundation\Testing\RefreshDatabase;
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
     * Test route register user store.
     */
    public function test_route_register_user_store(): void
    {
        $response = $this->post(route('register'));

        $response->assertRedirect(route('verification.notice'));
    }
}
