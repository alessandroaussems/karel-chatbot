<?php
namespace App\Events;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendToUser implements ShouldBroadcast
{
    public $data;
    public $channel;
    public $event;

    /**
     * SendToUser constructor.
     * @param $channel
     * @param $event
     * @param $data
     */
    public function __construct($channel, $event, $data)
    {
        $this->channel = $channel;
        $this->event=$event;
        $this->data=$data;
    }
    /**
     * @return array
     */
    public function broadcastOn()
    {
        return $this->channel;
    }

    /**
     * @return mixed
     */
    public function broadcastAs()
    {
        return $this->event;
    }

    /**
     * @return mixed
     */
    public function broadcastWith()
    {
        return $this->data;
    }
}