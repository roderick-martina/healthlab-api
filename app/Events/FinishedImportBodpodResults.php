<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Bodpod;
use Illuminate\Support\Collection;

class FinishedImportBodpodResults implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->message = 'Bodpod results are imported!';
        $this->user = $user;
    }

    public function broadcastAs()
    {
        return 'bodpod-finished';
    }

    public function broadcastWith()
    {
        $query = Bodpod::select(
            'bodpods.id',
            'bodpods.test_no',
            'bodpods.gender',
            'bodpods.age',
            'bodpods.activity_level'
        )
            ->paginate(7);
        $query->withPath('bodpod')->toArray();

        return [
            'data' => $query,
            'activities' => $this->getActivities()
        ];
    }

    public function getActivities()
    {
        $activitiesCollection = new Collection();

        $activities = Bodpod::all()->pluck('activity_level')->unique();
        $activities->each(function ($item, $key) use ($activitiesCollection) {
            $activitiesCollection->push($item);
        });

        return $activitiesCollection;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("users.{$this->user->id}");
    }
}
