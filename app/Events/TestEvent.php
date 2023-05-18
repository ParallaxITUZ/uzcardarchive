<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    private int $userId;

    /**
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->message = 'Worked';
        $this->userId = $userId;
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message
        ];
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('users.'.$this->userId);
    }

    public function broadcastAs()
    {
        return 'usersEvent';
    }
}
