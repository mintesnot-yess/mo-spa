<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ServiceStatusChange implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $services;
    public $serviceGroupId;

    public function __construct($services,$serviceGroupId)
    {
        $this->services = $services;
        $this->serviceGroupId = $serviceGroupId;
    }

    public function broadcastOn()
    {
        return new Channel('mospa-channel-service.' . $this->serviceGroupId);
    }
    public function broadcastAs()
    {
        return 'service.updated';
    }

}
