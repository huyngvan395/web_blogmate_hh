<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $type;
    public $link;
    public array $userTarget_id;

    public function __construct(
        $user_id,
        $type,
        $link,
        array $userTarget_id
    )
    {
        $this->user_id=$user_id;
        $this->type=$type;
        $this->link=$link;
        $this->userTarget_id=$userTarget_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return array_map(function ($id) {
            return new Channel("notifications.{$id}");
        }, $this->userTarget_id);
    }

    public function broadcastWith(): array
    {
        $user=User::find($this->user_id);
        return [
            'type' => $this->type,
            'link' => $this->link,
            'user' => $user
        ];
    }

}
