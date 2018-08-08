<?php
namespace skyimport\Http\Controllers;
use Illuminate\Http\Request;
use skyimport\Models\Consolidated;
use skyimport\Models\Tracking;
use skyimport\Models\EventsUsers;
use Yajra\DataTables\Datatables;
class NotificationController extends Controller
{
	public function __construct()
	{
		$this->middleware('ajax');
	}
	public function eventsAll(Request $request)
	{
		$consolidated = Consolidated::find($request->consolidated_id);
		$events = EventsUsers::query()->withTrashed()->limit(10);
		if (! is_null($consolidated)) {
			$c = $consolidated->id;
			foreach ($consolidated->trackings as $t) {
				$tr[] = $t->id;
			}
			if (isset($tr)) {
				$events = EventsUsers::whereIn('tracking_id', $tr)
				->where('event_id', '<>', 1)
				->where('event_id', '<>', 11)
				->where('event_id', '<>', 13)
				->where('event_id', '<>', 14)
				->where('event_id', '<>', 15)
				->orWhere('consolidated_id', '=', $c)
				->whereIn('event_id', [3,4,5,7,8,9,10,12])
				->orderBy('created_at', 'DESC');
			}
		}
		return (new Datatables)->of($events)
		->addColumn('fecha', function ($event) {
			return $event->created_at->format('d/m/Y');
		})
		->addColumn('hora', function ($event) {
			return $event->created_at->format('g:i:s a');
		})
		->addColumn('evento', function ($e) {
			if ($e->tracking_id == '') {
				if ($e->event_id == 3) {
					return 'Consolidado creado, en espera de recibir los paquetes con los trackings del consolidado para hacer el despacho.';
				} elseif ($e->event_id == 4) {
					return 'Trackings del consolidado recibidos, Salida de la bodega de Importadora Sky, destino: Bogotá, Colombia.';
				} elseif ($e->event_id == 5) {
					return 'Paquete recibido en Bogotá, Colombia. En espera, revisión por parte de la agencia de aduanas, Aeropuerto El Dorado BOG.';
				} elseif ($e->event_id == 7) {
					return 'Entregado a Importadora Sky. Se adjunta Orden de servicio por valor de $'.number_format($e->consolidated->bill, 2, ',', '.').' COP.';
				}
			} else {
				if ($e->event_id === 12 && $e->tracking) {
					return 'Tracking '.$e->tracking->tracking.' recibido en bodega Miami, Florida.';
				}
			}
			return $e->events->event;
		})
		->make(true);
	}
	public function notifications(Request $request)
	{
		if (\Auth::user()->role_id == 1) {
			$hoy = \Carbon::now()->format('Y-m-d');
			$notifications = Consolidated::where('closed_at', 'LIKE', '%'.$hoy.'%')
							->where('shippingstate_id', '=', 3)
							->orWhere('shippingstate_id', '=', 5)
							->orderBy('created_at', 'DESC')->get();
			$notifications_total = $notifications->count();
			$html = "<li class='header text-center'>$notifications_total  Consolidados formalizados hoy.</li>
						<li>
			              <ul class='menu'>";
			foreach ($notifications as $notification) {
				$consolidated = $notification->number;
				$hace = $notification->created_at->diffForHumans();
				$event = $notification->eventsUsers->last()->events->event;
				$html .= "<li id='notification' consolidated='$notification->id'>
	                  <a href='#'>
	                      <i class='fa fa-cube text-primary'></i>
	                      $consolidated
	                      <small><i class='fa fa-clock-o'></i> $hace</small>
	                    <p>$event</p>
	                  </a>
	                </li>";
			}
			$html .= "</ul>
		            </li>
	            <li class='footer'><a href='/consolidados'>Ver todos</a></li>";
		} else {
			$user = \Auth::user()->id;
			$consolidados = Consolidated::where('user_id', '=', $user)->limit(10)->get();
			$notifications_total = 0;
			$html = "<li class='header'> Eventos en Trackings.</li>
						<li>
			              <ul class='menu'>";
			if (\Auth::user()->city == null) {
				$notifications_total++;
				$html .= "<li>
	                <li>
	                  <a href='/perfil'>
	                    <h4>
	                      <i class='fa fa-user text-primary'></i>
	                      Perfil del usuario
	                      <small><i class='fa fa-clock-o'></i> ".\Carbon::now()->diffForHumans()."</small>
	                    </h4>
	                    <p>Completa tu Perfil</p>
	                  </a>
	                </li>
	            </li>";
			}
			$id = [];
			foreach ($consolidados as $c) {
				foreach ($c->eventsUsers as $e) {
					$id[] = $e->id;
				}
				foreach ($c->trackings as $t) {
					foreach ($t->eventsUsers as $e) {
						if ($c->shippingstate_id >= 5 && $e->event_id == 15)  continue;
						if ($e->event_id == 11) continue;
						$id[] = $e->id;
					}
				}
			}
			$id = array_unique($id);
			$event = EventsUsers::whereIn('id', $id)->orderBy('created_at', 'DESC')->limit(15)->get();
			foreach ($event as $e) {
				if ($e->consolidated_id == null) {
					if (in_array($e->event_id, [12,13,15])) {
						if ($e->event_id == 15 && $e->tracking->consolidated->shippingstate_id < 5) continue;
						if ($e->viewed == 0) {
							$notifications_total++;
						}
						$tracking = $e->tracking->tracking;
						$consolidated = $e->tracking->consolidated;
						$fecha = $e->created_at->diffForHumans();
						$evento = $e->events;
						$html .= "<li>
			                <li id='notification' consolidated='$consolidated->id'>
			                  <a href='#'>
			                    <h4>
			                      <i class='fa fa-cubes text-primary'></i>
			                      $tracking
			                      <small><i class='fa fa-clock-o'></i> $fecha</small>
			                    </h4>
			                    <p>$evento->event</p>
			                  </a>
			                </li>
			            </li>";
					}
		        } elseif ($e->tracking_id == null) {
		        	if (in_array($e->event_id, [4,5,6])) {
		        		if ($e->viewed == 0) {
		        			$notifications_total++;
		        		}
						$consolidated = $e->consolidated;
						$fecha = $e->created_at->diffForHumans();
						$evento = $e->events;
						$html .= "<li>
			                <li id='notification' consolidated='$consolidated->id'>
			                  <a href='#'>
			                    <h4>
			                      <i class='fa fa-cube text-primary'></i>
			                      $consolidated->number
			                      <small><i class='fa fa-clock-o'></i> $fecha</small>
			                    </h4>
			                    <p>$evento->event</p>
			                  </a>
			                </li>
			            </li>";
					}
				}
			}
			$html .= "</ul>
		            </li>
	            <li class='footer'><a href='/consolidados'>Ver todos los consolidados</a></li>";
		}
		return response()->json(compact('html', 'notifications_total'));
	}
	public function viewer()
	{
		if (\Auth::user()->role_id == 1) {
		} else {
			$user = \Auth::user()->id;
			$consolidados = Consolidated::where('user_id', '=', $user)->limit(10)->get();
			$id = [];
			foreach ($consolidados as $c) {
				foreach ($c->eventsUsers as $e) {$id[] = $e->id; }
				foreach ($c->trackings as $t) {
					foreach ($t->eventsUsers as $e) {$id[] = $e->id; }
				}
			}
			$id = array_unique($id);
			$event = EventsUsers::whereIn('id', $id)->orderBy('created_at', 'DESC')->limit(30)->get();
			$event->each(function ($e) {
				$e->update(['viewed' => 1]);
			});
		}
	}
	public function store(Request $request)
	{
		$eventos = EventsUsers::where('tracking_id', '=', $request->tracking)
		->where('event_id', '>=', $request->event)->count();
		if ($eventos) {
			return response()->json(['msg' => 'Ya el tracking paso por este evento.']);
		}
		$id = Tracking::findOrFail($request->tracking)->consolidated->id;
        Tracking::findOrFail($request->tracking)
        ->update(['shippingstate_id' => $request->event]);
		EventsUsers::create([
			'tracking_id' => $request->tracking,
			'event_id' => $request->event,
		]);
		$this->changeStateOfConsolidated($id, $request->event);
		return;
	}
	public static function changeStateOfConsolidated($id, $event)
	{
		$event_current = Consolidated::findOrFail($id)->eventsUsers->last()->event_id;
		if ($event == 12 || $event == 13) {
			if ($event_current < 4) { Self::allStatusInMiami($id); }
		}
		if ($event == 15) {
			if ($event_current <= 5) { Self::allTrackingsInColombia($id); }
		}
	}
	public static function allTrackingsInColombia($id)
	{
		$consolidated = Consolidated::findOrFail($id);
		$num = true;
		$trackings = $consolidated->trackings;
		foreach ($trackings as $t) {
			$event = $t->shippingstate_id;
			if ($event < 15) {
				$num = false;
			}
		}
		if ($num) {
			EventsUsers::create([
				'consolidated_id' => $consolidated->id,
				'event_id' => 6,
			]);
			$consolidated->shippingstate_id = 6;
			$consolidated->weight = 0;
			$consolidated->bill = 0;
			//\Mail::to($consolidated->user->email)->send(new \skyimport\Mail\CambioDeEstatus($consolidated));
			$consolidated->save();
		}
	}
	public static function allStatusInMiami($id)
	{
		$consolidated = Consolidated::findOrFail($id);
		$num = true;
		$trackings = $consolidated->trackings;
		foreach ($trackings as $t) {
			$event = $t->shippingstate_id;
			if ($event < 12) {
				$num = false;
			}
		}
		if ($num) {
			$consolidated->update(['shippingstate_id' => 4]);
			foreach ($trackings as $t) {
				$t->update(['shippingstate_id' => 13]);
				EventsUsers::create([
					'tracking_id' => $t->id,
					'event_id' => 13,
				]);
			}
			sleep(1);
			EventsUsers::create([
				'consolidated_id' => $consolidated->id,
				'event_id' => 4,
			]);
			\Mail::to($consolidated->user->email)->send(new \skyimport\Mail\CambioDeEstatus($consolidated));
		}
	}
    public function events($id)
    {
        $consolidated = Consolidated::findOrFail($id);
        $trackings = [];
        foreach ($consolidated->trackings as $c) {
            $trackings[] = $c->id;
        }
        $event = EventsUsers::whereIn('tracking_id', $trackings)->Orwhere('consolidated_id', '=', $id)->orderBy('created_at')->get();
        $event->each(function ($e) use ($consolidated) {
            $e->created = $e->created_at->format('d M. Y');
            $e->hour = $e->created_at->format('h:m');
            if ($e->tracking_id != null) {
	            $e->trackings = Tracking::find($e->tracking_id);
            } else {
	            $e->consolidated = $consolidated;
            }
            $e->events;
        });
        return response()->json(compact('event', 'consolidated'));
    }
    public function addEvent(Request $request)
    {
    	$consolidated = Consolidated::findOrFail($request->consolidated);
		$consolidated->update(['shippingstate_id' => $request->event]);
		EventsUsers::create([
			'consolidated_id' => $request->consolidated,
			'event_id' => $request->event,
		]);
		if ($consolidated->shippingstate_id != 6) {
			\Mail::to($consolidated->user->email)->send(new \skyimport\Mail\CambioDeEstatus($consolidated));
		}
		$num = $consolidated
				->eventsUsers
				->whereIn('event_id', [7,8,9])
				->count();
		if ($num == 3) {
			$consolidated->update(['shippingstate_id' => 10]);
			EventsUsers::create([
				'consolidated_id' => $request->consolidated,
				'event_id' => 10,
			]);
		}
    }
}