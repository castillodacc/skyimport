<?php

namespace skyimport\Console\Commands;

use Illuminate\Console\Command;
use skyimport\Models\Consolidated;
use skyimport\Models\EventsUsers;

class ConsolidatedInColombia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consolidated:beforeAduana';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Un día hábil después de que se dio notificación de vuelo, llegan a Colombia y entran en aduana';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dia = \Carbon::now()->formatLocalized('%A');
        if ($dia != 'sábado' && $dia != 'domingo') {
            $consolidateds = Consolidated::where('shippingstate_id', 4)->get();
            $consolidateds->each(function ($c) {
                $event = $c->eventsUsers->where('event_id', 4)->first();
                if ($event->created_at->diffInHours(\Carbon::now()) == 24) {
                    $c->trackings->each(function ($t) {
                        $t->update(['shippingstate_id' => 14]);
                        EventsUsers::create([
                            'tracking_id' => $t->id,
                            'event_id' => 14,
                        ]);
                    });
                    $c->update(['shippingstate_id' => 5]);
                    EventsUsers::create([
                        'consolidated_id' => $c->id,
                        'event_id' => 5,
                    ]);
                }
            });
        }

        // evalua que el consolidado que ya expire su fecha de formalizacion pase de evento.
        $consolidated = skyimport\Models\Consolidated::where('shippingstate_id', '<', 3)->get();
        $consolidated->each(function ($c) {
            if ($c->trackings->count()) {
                if ($c->closed_at < \Carbon::now()) {
                    $c->shippingstate_id = 3;
                    EventsUsers::create([
                        'consolidated_id' => $c->id,
                        'event_id' => 3,
                    ]);
                    $admins = \skyimport\User::where('role_id', '=', 1)->get();
                    foreach ($admins as $admin) {
                        \Mail::to($admin->email)->send(new \skyimport\Mail\Formalizado($c));
                    }
                    $c->save();
                }
            } else {
                if ($c->created_at->diffInHours(\Carbon::now()) == 1) {
                    $c->delete();
                }
            }
        });
    }
}
