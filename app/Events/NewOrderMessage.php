<?php

namespace App\Events;

use App\OrderMessage;
use Auth;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewOrderMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderMessage;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(OrderMessage $orderMessage)
    {
        //
        $this->orderMessage = $orderMessage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('orderMessages');
    }


    public function broadcastWith()
    {
        return ["orderMessage" => $this->orderMessage,"user"=>Auth::user()->name];
    }
}
