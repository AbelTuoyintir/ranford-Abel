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

class VoteUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $candidateId;
    public $voteCount;
    public function __construct($candidateId, $voteCount)
    {
        $this->candidateId = $candidateId;
        $this->voteCount = $voteCount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return [
            new Channel('strongrooms'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'VoteUpdated';
    }


    public function broadcastWith(): array
    {
        return [
            'candidateId' => $this->candidateId,
            'voteCount' => $this->voteCount,
        ];
    }

}
