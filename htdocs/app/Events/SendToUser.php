<?php
namespace App\Events;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendToUser implements ShouldBroadcast
{
    public $data;
    public $channel;
    public $event;

    public function __construct($channel,$event,$data)
    {
        $this->channel = $channel;
        $this->event=$event;
        $this->data=$data;
    }


    public function broadcastOn()
    {
        return $this->channel;
    }
    public function broadcastAs()
    {
        return $this->event;
    }
    public function broadcastWith()
    {
        return $this->data;
    }
}