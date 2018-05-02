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
        // - Un día hábil después de que se dio notificación de vuelo, llegan a Colombia y entran en aduana que ese es otro estado de consolidado y también se notifica.
        // - salida miami - bogota un dia habil de la anterior se coloca en estado "colombia - aduana" 
        // 24 hotas luego que se coloca el consolidado en "salida de miami a bogota" llega a colombia
        $dia = \Carbon::now()->formatLocalized('%A');
        if ($dia != 'sábado' && $dia != 'domingo') {
            $consolidateds = Consolidated::where('shippingstate_id', 4)->get();
            $consolidateds->each(function ($c) {
                $event = $c->eventsUsers->last();
                if ($event->event_id == 4 && 
                    $event->created_at->diffInHours(\Carbon::now()) == 24) {
                    EventsUsers::create([
                        'consolidated_id' => $c->id,
                        'event_id' => 5,
                    ]);
                    $c->update(['shippingstate_id' => 5]);
                }
            });
        }

        // evalua que el consolidado que ya expire su fecha de formalizacion pase de evento.
        $consolidated = Consolidated::where('closed_at', '<', \Carbon::now())->where('shippingstate_id', '<', 3)->get();
        $consolidated->each(function ($c) {
            if ($c->trackings->count()) {
                $c->shippingstate_id = 3;
                EventsUsers::create([
                    'consolidated_id' => $c->id,
                    'event_id' => 3,
                ]);
                $c->save();
            } else {
                $c->delete();
            }
        });
    }
}
