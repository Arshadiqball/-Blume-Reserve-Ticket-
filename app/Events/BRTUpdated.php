<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\Log; // Add this

class BRTUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $brt;

    /**
     * Create a new event instance.
     */
    public function __construct($brt)
    {
        $this->brt = $brt;

        // Log the message when the event is instantiated
        Log::info('BRTUpdated Event Created', ['brt' => $this->brt]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        // Log the channel name
        Log::info('BRTUpdated Event Broadcasting on Channel', ['channel' => 'notification']);

        return new Channel('notification');
    }

    /**
     * Data that should be sent with the broadcast.
     */
    public function broadcastWith()
    {
        Log::info('BRTUpdated Event Data', ['data' => $this->brt]);

        return ['brt' => $this->brt];
    }

    public function broadcastAs()
    {
        return 'analytics';
    }
}
