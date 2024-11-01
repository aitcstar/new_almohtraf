<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvitationAccepted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $projectId;

    public function __construct($userId, $projectId)
    {
        $this->userId = $userId;
        $this->projectId = $projectId;

        //dd($this->userId);
    }

    public function broadcastOn()
    {
        return new Channel('user-notifications-' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'invitation.accepted';
    }

    public function broadcastWith()
    {
        return ['message' => 'لديك إشعار جديد!'];
    }
}
