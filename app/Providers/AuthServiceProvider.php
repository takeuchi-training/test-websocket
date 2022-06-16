<?php

namespace App\Providers;

use App\Models\Room;
use App\Models\User;
use App\Services\ChatServiceInterface;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('enter_room', function (User $user, $room_id) {
            $chatService = app()->make(ChatServiceInterface::class);
            return $chatService->isUserInGroupChat($room_id, $user->id);
        });
    }
}
