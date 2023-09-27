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
Broadcast::channel('public', function () {
    return true;
});
Broadcast::channel('private.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('private-private.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('presence.{groupId}', function ($user,int $groupId) {
    if( $groupId == 1 && $user->authtype='admin') return ['id' => $user->id, 'name' => $user->name];
    else if( $groupId == 2 && $user->authtype='member') return ['id' => $user->id, 'name' => $user->name];
    else return false;

    if ($user->canJoinGroup($groupId)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});
Broadcast::channel('presence-presence.{groupId}', function ($user,int $groupId) {
    if( $groupId == 1 && $user->authtype='admin') return ['id' => $user->id, 'name' => $user->name];
    else if( $groupId == 2 && $user->authtype='member') return ['id' => $user->id, 'name' => $user->name];
    else return false;
    
    if ($user->canJoinGroup($groupId)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});
