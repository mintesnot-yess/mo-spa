<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class staffCustomerStatusChange implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
public $customers;
public $employeeId;
    /**
     * Create a new event instance.
     */
    public function __construct($customers,$employeeId)
    {
        $this->customers = $customers;
        
        $this->employeeId = $employeeId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {        
            return new Channel('mospa-channel-staff.' . $this->employeeId);
    }
    public function broadcastAs()
    {
        return 'staff.customer.updated';
    }
}
