<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    /**
     * Test route verification notice guests.
     *  
     */
    public function test_route_verification_notice_guests(): void
    {
        $response = $this->get(route('verification.notice'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test route verification notice unverified.
     *  
     */
    public function test_route_verification_notice_unverified(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get(route('verification.notice'));

        $response->assertStatus(200);
    }

    /**
     * Test route verification notice view.
     *  
     */
    public function test_route_verification_notice_view(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get(route('verification.notice'));

        $response->assertViewIs('user.verify-email');
    }

    /**
     * Test route verification notice verified.
     *  
     */
    public function test_route_verification_notice_verified(): void
    {
        $user = User::factory()->verified()->create();

        $response = $this->actingAs($user)->get(route('verification.notice'));

        $response->assertRedirect('/');
    }

    /**
     * Test route verification send guests.
     *  
     */
    public function test_route_verification_send_guests(): void
    {
        $response = $this->post(route('verification.send'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test route verification send unverified.
     *  
     */
    public function test_route_verification_send_unverified(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)
            ->from(route('verification.notice'))
            ->post(route('verification.send'));

        $response->assertRedirect(route('verification.notice'));
    }

    /**
     * Test route verification send unverified.
     *  
     */
    public function test_route_verification_send_resend_verification_email(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->post(route('verification.send'));

        Notification::assertSentTo(
            [$user],
            VerifyEmail::class
        );
    }

    /**
     * Test route verification send message.
     *  
     */
    public function test_route_verification_send_message(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->post(route('verification.send'));

        $response->assertSessionHas('status', 'Ссылка для подтверждения отправлена!');
    }

    /**
     * Test route verification send verified.
     *  
     */
    public function test_route_verification_send_verified(): void
    {
        $user = User::factory()->verified()->create();

        $response = $this->actingAs($user)->post(route('verification.send'));

        $response->assertRedirect('/');
    }

    /**
     * Test route verification send throttle.
     *  
     */
    public function test_route_verification_send_throttle(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)
            ->from(route('verification.notice'))
            ->post(route('verification.send'));

        $response->assertRedirect(route('verification.notice'));

        $response2 = $this->actingAs($user)
            ->from(route('verification.notice'))
            ->post(route('verification.send'));

        $response2->assertRedirect(route('verification.notice'));

        $response3 = $this->actingAs($user)
            ->from(route('verification.notice'))
            ->post(route('verification.send'));

        $response3->assertStatus(429);

        $this->travel(61)->seconds();

        $response4 = $this->actingAs($user)
            ->from(route('verification.notice'))
            ->post(route('verification.send'));

        $response4->assertRedirect(route('verification.notice'));
    }

    /**
     * Test route verification verify guests.
     */
    public function test_route_verification_verify_guests(): void
    {
        $response = $this->get('/email/verify/{id}/{hash}');

        $response->assertRedirect(route('login'));
    }

    /**
     * Test route verification verify verified.
     *  
     */
    public function test_route_verification_verify_verified(): void
    {
        $user = User::factory()->verified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect('/');
    }

    /**
     * Test route verification verify.
     */
    public function test_route_verification_verify(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect(route('user.dashboard', ['user' => $user]));
    }

    /**
     * Test route verification verify Email.
     */
    public function test_route_verification_verify_email(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        $this->actingAs($user)->get($verificationUrl);

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    /**
     * Test route verification verify message.
     *  
     */
    public function test_route_verification_verify_message(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertSessionHas('status', 'Email подтвержден!');
    }

    /**
     * Test route verification verify invalid signature.
     *  
     */
    public function test_route_verification_verify_invalid_signature(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        $brokenUrl = $verificationUrl . 'broken';

        $response = $this->actingAs($user)->get($brokenUrl);


        $response->assertStatus(403);
        $this->assertNull($user->fresh()->email_verified_at);
    }

    /**
     * Test route verification verify invalid signature null email.
     *  
     */
    public function test_route_verification_verify_invalid_signature_null_email(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        $brokenUrl = $verificationUrl . 'broken';

        $this->actingAs($user)->get($brokenUrl);

        $this->assertNull($user->fresh()->email_verified_at);
    }

    /**
     * Test route verification verify expired signature.
     */
    public function test_route_verification_verify_expired_signature(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addSeconds(0.1),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertStatus(403);
    }

    /**
     * Test route verification verify expired signature null email.
     */
    public function test_route_verification_verify_expired_signature_null_email(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addSeconds(0.1),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        $this->actingAs($user)->get($verificationUrl);

        $this->assertNull($user->fresh()->email_verified_at);
    }

    /**
     * Test route verification verify others email.
     */
    public function test_route_verification_verify_others_email(): void
    {
        $user1 = User::factory()->unverified()->create();
        $user2 = User::factory()->unverified()->create();

        $urlForUser2 = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(1),
            ['id' => $user2->id, 'hash' => sha1($user2->getEmailForVerification())]
        );

        $response = $this->actingAs($user1)->get($urlForUser2);

        $response->assertStatus(403);
    }

    /**
     * Test route verification verify others email null email1.
     */
    public function test_route_verification_verify_others_email_null_email1(): void
    {
        $user1 = User::factory()->unverified()->create();
        $user2 = User::factory()->unverified()->create();

        $urlForUser2 = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(1),
            ['id' => $user2->id, 'hash' => sha1($user2->getEmailForVerification())]
        );

        $this->actingAs($user1)->get($urlForUser2);

        $this->assertNull($user1->fresh()->email_verified_at);
    }

    /**
     * Test route verification verify others email null email2.
     */
    public function test_route_verification_verify_others_email_null_email2(): void
    {
        $user1 = User::factory()->unverified()->create();
        $user2 = User::factory()->unverified()->create();

        $urlForUser2 = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(1),
            ['id' => $user2->id, 'hash' => sha1($user2->getEmailForVerification())]
        );

        $this->actingAs($user1)->get($urlForUser2);

        $this->assertNull($user2->fresh()->email_verified_at);
    }

    /**
     * Test route verification verify email not match.
     */
    public function test_route_verification_verify_email_not_match(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(1),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        $user->update(['email' => 'new@example.com']);

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertStatus(403);
    }

    /**
     * Test route verification verify email not match null email.
     */
    public function test_route_verification_verify_email_not_match_null_email(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(1),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        $user->update(['email' => 'new@example.com']);

        $this->actingAs($user)->get($verificationUrl);

        $this->assertNull($user->fresh()->email_verified_at);
    }
}
