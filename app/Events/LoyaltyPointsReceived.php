<?php

namespace App\Events;

use App\Models\LoyaltyAccount;
use App\Models\LoyaltyPointsTransaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoyaltyPointsReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public LoyaltyAccount $account;
    public LoyaltyPointsTransaction $transaction;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct(LoyaltyAccount $account, LoyaltyPointsTransaction $transaction)
    {
        $this->account = $account;
        $this->transaction = $transaction;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
