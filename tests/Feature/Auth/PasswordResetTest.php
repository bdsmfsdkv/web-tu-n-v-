<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_screen_can_be_rendered(): void
    {
        $this->get('/forgot-password')
            ->assertOk();
    }

    public function test_unknown_email_is_rejected(): void
    {
        $this->from('/forgot-password')
            ->post('/forgot-password', [
                'email' => 'missing@example.com',
            ])
            ->assertRedirect('/forgot-password')
            ->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => 'missing@example.com',
        ]);
    }

    public function test_reset_link_request_creates_token_and_sends_raw_mail(): void
    {
        $user = User::factory()->create();

        // PasswordResetLinkController currently sends a raw SMTP message instead
        // of Laravel's ResetPassword notification, so mock the real code path.
        Mail::shouldReceive('raw')
            ->once()
            ->andReturnNull();

        $this->from('/forgot-password')
            ->post('/forgot-password', [
                'email' => $user->email,
            ])
            ->assertRedirect('/forgot-password')
            ->assertSessionHas('status')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }

    public function test_recent_reset_request_is_throttled(): void
    {
        $user = User::factory()->create();

        // Only the first request should reach the mail sender. The second request
        // should be stopped by recentlyCreatedToken().
        Mail::shouldReceive('raw')
            ->once()
            ->andReturnNull();

        $this->post('/forgot-password', [
            'email' => $user->email,
        ])->assertSessionHasNoErrors();

        $this->post('/forgot-password', [
            'email' => $user->email,
        ])->assertSessionHasErrors('email');
    }

    public function test_reset_password_screen_can_be_rendered_with_real_token(): void
    {
        $user = User::factory()->create();
        $token = Password::broker()->createToken($user);

        $this->get(route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]))->assertOk();
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('OldPassword123!'),
        ]);
        $token = Password::broker()->createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'))
            ->assertSessionHas('status');

        $user->refresh();
        $this->assertTrue(Hash::check('NewPassword123!', $user->password));

        // Laravel deletes the used token after a successful reset.
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }

    public function test_invalid_token_does_not_change_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('OldPassword123!'),
        ]);

        $this->from('/reset-password/bad-token')
            ->post('/reset-password', [
                'token' => 'bad-token',
                'email' => $user->email,
                'password' => 'NewPassword123!',
                'password_confirmation' => 'NewPassword123!',
            ])
            ->assertRedirect('/reset-password/bad-token')
            ->assertSessionHasErrors('email');

        $user->refresh();
        $this->assertTrue(Hash::check('OldPassword123!', $user->password));
    }
}
