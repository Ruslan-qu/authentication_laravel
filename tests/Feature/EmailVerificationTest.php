<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    /**
     * Test route verification notice.
     *  
     */
    public function test_route_verification_notice(): void
    {
        $id = User::factory()->create([
            'email_verified_at' => null,
        ])->getAttributeValue('id');
        
        $user = User::all()->find($id);

        $response = $this->actingAs($user)->get(route('verification.notice'));

        $response->assertStatus(200);
        //dd($user);
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
