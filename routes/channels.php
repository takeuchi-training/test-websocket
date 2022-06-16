<?php

use App\Repositories\ChatRepositoryInterface;
use App\Services\ChatServiceInterface;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('presence.group.chat.{room_id}', function ($user, $room_id) {
    $chatService = app()->make(ChatServiceInterface::class);

    if ($chatService->isUserInGroupChat($room_id, $user->id)) {
        return [ 'id' => $user->id, 'name' => $user->name, 'email' => $user->email ];
    }

    return null;
});