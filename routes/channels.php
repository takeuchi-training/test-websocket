<?php

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

Broadcast::channel('presence.group.chat', function ($user) {
    $adminEmails = [
        'giangnhattruong@gmail.com',
        'admin1@admin.com',    
        'admin2@admin.com',    
        'admin3@admin.com',    
    ];

    if (in_array($user->email, $adminEmails)) {
        return [ 'id' => $user->id, 'name' => $user->name, 'email' => $user->email ];
    }

    return null;
});