<?php

namespace Modules\Telegram\Events;

use Illuminate\Queue\SerializesModels;

class RegisterClosed
{
    use SerializesModels;

    public $register_details;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($register_details)
    {
        $this->register_details = $register_details;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
