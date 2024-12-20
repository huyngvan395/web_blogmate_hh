<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversationID;
    // public $name;
    // public $content;
    // public $type;
    // public $sender_id;
    // public $receiver_id;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public int $id,
        $conversationID,
        public int $user_id,
        public string $content,
        public string $type,
        public string $create_at
    ) {
        $this->conversationID = $conversationID;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return  \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('conversations.' . $this->conversationID);
        // return new Channel('messages');
    }

    // /**
    //  * Get the data to broadcast.
    //  *
    //  * @return array<string, mixed>
    //  */
    public function broadcastWith(): array
    {
        $message = \App\Models\Message::find($this->id);
        if (!$message) {
            return [];
        }

        return [
            'id' => $message->id,
            'conversation_id' => $message->conversation_id,
            'user_id' => $message->user_id,
            'content' => $message->content,
            'type' => $message->type,
            'created_at' => $message->created_at->toDateTimeString(),
            'formatted_time' => $message->formatted_time, // Accessor
        ];
        
    }
}
