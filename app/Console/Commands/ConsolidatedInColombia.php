<?php

namespace skyimport\Console\Commands;

use Illuminate\Console\Command;
use skyimport\Models\Consolidated;

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
        // \DB::table('events')->delete();
        // 10 En Aduana de Colombia.
        // - Un día hábil después de que se dio notificación de vuelo, llegan a Colombia y entran en aduana que ese es otro estado de consolidado y también se notifica.
        // - salida miami - bogota un dia habil de la anterior se coloca en estado "colombia - aduana" 
        // $dia = \Carbon::now()->formatLocalized('%A');
        // if ($dia != 'sábado' && $dia != 'domingo') {
        //     $consolidateds = Consolidated::where('closed_at', '<', \Carbon::now())->where('closed_at', '>', \Carbon::now()->addsemana!!)->get();
        //     $consolidateds->each(function ($c) {
        //         $event = $c->eventsUsers->last();
        //         if ($event->id == 4 && $event->created_at fue hace 24 horas) {
        //             EventsUsers::create([
        //                 'consolidated_id' => $c->id,
        //                 'event_id' => 10,
        //             ]);
        //         }
        //     });
        // }
    }
}
