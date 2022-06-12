<?php

namespace Tests\Feature;

use App\Events\RegisterUserEvent;
use App\Jobs\SendWelcomeEmailJob;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void {
        parent::setUp();
        // Event::fake([
        //     RegisterUserEvent::class,
        // ]);
        // Queue::fake();
        Mail::fake();
    }

    public function test_email_sent_after_user_registered() {
        $this->withoutExceptionHandling();
        $user = User::factory()->make();

        $response = $this->json(
            $method = 'POST',
            $uri = '/register',
            $data = [
                    'email' => $user->email,
                    'name' => $user->name,
                    'password' => 'Test@123',
                    'password_confirmation' => 'Test@123',
                ],
        );

        // Event::assertDispatched(RegisterUserEvent::class);
        // Queue::assertPushedOn('emails', SendWelcomeEmailJob::class);

        Mail::assertSent(WelcomeEmail::class);
        $response->assertStatus(302);

        $userResult = User::find(1);
        $this->assertSame($user->email, $userResult->email, "Email doesn't match");
        $this->assertSame($user->name, $userResult->name, "Name doesn't match");
    }
}
