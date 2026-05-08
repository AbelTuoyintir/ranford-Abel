<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('strongrooms', function () {
     // Allows anyone to listen to this channel
});

Broadcast::channel('verification', function () {
     // Allows anyone to listen to this channel
});

// Broadcast::channel('poll', function () {
//      // Allows anyone to listen to this channel
// });

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Broadcast::channel('strong-room');