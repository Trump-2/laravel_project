<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// 授權 channel
Broadcast::channel('chatchannel', function () {
    if (auth()->check()) {
        return true;
    }
    return false;
});
