<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;
use App\Models\Mbca;
use App\Http\Resources\MbcaResource;
use App\Http\Resources\MbcaEventResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class FinishedImportMbcaResults implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;

    }

    public function broadcastAs()
    {
        return 'mbca-finished';
    }

    public function broadcastWith()
    {
        // $ethnicictiesCollection = new Collection();

        // $ethnicicties = Mbca::all()->pluck('ethnic')->unique();
        // $ethnicicties->each(function ($item, $key) use ($coll) {
        //     $coll->push($item);
        // });

        $query = DB::table('mbcas')
            ->leftJoin('patients', 'mbcas.patient_id', '=', 'patients.id')
            ->select(
                'mbcas.id',
                'mbcas.identifier as patient_identifier',
                'patients.valid_identifier as valid_identifier',
                'mbcas.gender',
                'mbcas.bmi_value'
            )
            ->selectRaw("date_part('year', age(mbcas.date_of_birth)) as age")
            ->paginate(7);
        $query->withPath('mbca')->toArray();

        return [
            'data' => $query,
            'ethnicicties' => $this->getEthnicicties()
        ];
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

    protected function getEthnicicties()
    {
        $ethnicictiesCollection = new Collection();

        $ethnicicties = Mbca::all()->pluck('ethnic')->unique();
        $ethnicicties->each(function ($item, $key) use ($ethnicictiesCollection) {
            $ethnicictiesCollection->push($item);
        });

        return $ethnicictiesCollection;
    }
}
