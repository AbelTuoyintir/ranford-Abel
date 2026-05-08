<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class LogUserToStrongRoom implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $schoolId;
    public $image;
    public $action;
    public $hall;

    public function __construct($schoolId, $image,$hall, $action)
    {
        $this->schoolId = $schoolId;
        $this->image = $image;
        $this->action = $action;
        $this->hall = $hall;
    }

    public function broadcastOn()
    {
        return new Channel('strongrooms'); // Broadcast to the 'strongroom' channel
    }

    public function broadcastAs()
    {
        return 'user.logged.in'; // Custom event name
    }

}