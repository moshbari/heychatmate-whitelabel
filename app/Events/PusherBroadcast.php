<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $chat_id;
    public $from;

    public function __construct($message,$chat_id,$from)
    {
        $this->message = $message;
        $this->chat_id = $chat_id;
        $this->from = $from;
    }

    public function broadcastOn(): array
    {
        return ['chat-'.$this->chat_id];
    }

    public function broadcastAs(): string
    {
        return 'event-'.$this->chat_id;
    }
}
