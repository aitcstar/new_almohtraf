<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class UserNotified implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        //dd($this->user->id);
    }

    public function broadcastOn()
    {
        return new Channel('user-' . $this->user->id);
    }

    public function broadcastAs()
    {
        return 'project.status.updated';
    }

    public function broadcastWith()
    {
        return ['message' => 'لديك إشعار جديد!'];
    }
}
