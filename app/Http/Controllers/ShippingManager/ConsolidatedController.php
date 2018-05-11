<?php

namespace skyimport\Http\Controllers\ShippingManager;

use Illuminate\Http\Request;
use skyimport\Http\Controllers\Controller;
use skyimport\Models\Distributor;
use skyimport\Models\Consolidated;
use Yajra\DataTables\Datatables;
use skyimport\Models\Tracking;
use skyimport\Models\Events;
use skyimport\Models\EventsUsers;
use skyimport\User;

class ConsolidatedController extends Controller
{
    public function __construct()
    {
        $this->middleware('ajax')->except(['index', 'events']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!request()->ajax()) return view('sendings.manager');

        $request = request();
        $object = Consolidated::query()
        ->with(['user'])
        ->select([
            'id',
            'closed_at',
            'user_id',
            'created_at',
            'number',
            'bill',
            'shippingstate_id'
        ]);
        if ($request->c === 'abierto') {
            $object->where('closed_at', '>', \Carbon::now());
        } else {
            $object->where('closed_at', '<', \Carbon::now())->orderBy('closed_at', 'DESC');
        }


        if (\Auth::user()->role_id == 2) {
            $object->where('user_id', '=', \Auth::user()->id);
        }

        return (new Datatables)->of($object)
        ->addColumn('action', function ($consolidated) {
            $name = (request()->c === 'abierto') ? 'consolidated' : 'consolidated2';
            $html = '<div class="text-center">';
            $nameView = 'view-formalized';
            $nameDelete = 'delete-formalized';
            if (request()->c === 'abierto') {
                $nameView = 'viewConsolidated';
                $nameDelete = 'deleteConsolidated';
            }
            if (request()->c !== 'abierto' && \Auth::user()->role_id === 1) {
                if ($consolidated->shippingstate_id == 5 && $consolidated->bill == 0) {
                    $html .= '
                        <button id="factureConsolidated" type="button" class="btn bg-purple btn-flat btn-xs" consolidated="' . $consolidated->id . '"><span class="fa fa-dollar"></span> Orden de Servicio</button>
                    ';
                } elseif ($consolidated->shippingstate_id > 5) {
                    $e = $consolidated->eventsUsers->where('event_id', '=', 7)->count();
                    $p = $consolidated->eventsUsers->where('event_id', '=', 8)->count();
                    if (! $e) {
                        $html .= '
                            <button id="editEventConsolidated" type="button" class="btn btn-success btn-flat btn-xs" consolidated="' . $consolidated->id . '" event="7"><span class="glyphicon glyphicon-ok"></span> Entregado</button>
                        ';
                    }
                    if (! $p) {
                        $html .= '
                            <button id="editEventConsolidated" type="button" class="btn bg-navy btn-flat btn-xs" consolidated="' . $consolidated->id . '" event="8"><span class="fa fa-list-alt"></span> Pagado</button>
                        ';
                    }
                }
            }
            $extend = $consolidated->eventsUsers->where('event_id', '=', 2)->count();
            $var = false;
            $event = $consolidated->eventsUsers->last();
            if ($event->event_id == 3) {
                $horas = $event->created_at->diffInHours(\Carbon::now());
                if ($horas < 24) $var = true;
            }
            if ((request()->c == 'abierto' && $extend < 2) || (\Auth::user()->role_id == 1 && $var) ) {
                $html .= '
                    <button id="extendConsolidated" type="button" class="btn btn-warning btn-flat btn-xs" consolidated="' . $consolidated->id . '"><span class="fa fa-calendar-plus-o"></span> Extender</button>
                ';
            }
            $html .= '
                <button id="'.$nameView.'" type="button" class="btn btn-info btn-flat btn-xs" consolidated="' . $consolidated->id . '"><span class="fa fa-eye"></span> Mostrar</button>
            ';

            if ((\Auth::user()->role_id == 2 && ($consolidated->shippingstate_id < 3 || $var)) ||
                (\Auth::user()->role_id == 1 && $consolidated->shippingstate_id < 5)) {
                $html .= '
                    <button id="editConsolidated" type="button" class="btn btn-primary btn-flat btn-xs" consolidated="' . $consolidated->id . '"><span class="fa fa-pencil"></span> Editar</button>
                ';
            }
            if (request()->c != 'abierto') {
                $html .= '
                <button id="edit-formalized" type="button" class="btn bg-teal btn-flat btn-xs" consolidated="' . $consolidated->id . '"><span class="fa fa-list"></span> Eventos</button>
                ';
            }
            if (\Auth::user()->role_id === 1 || request()->c === 'abierto') {
                $html .= '
                    <button id="'.$nameDelete.'" type="button" class="btn btn-danger btn-flat btn-xs" consolidated="' . $consolidated->id . '"><span class="fa fa-trash"></span> Eliminar</button>
                ';
            }
            $html .= '</div>';
            return $html;
        })
        ->editColumn('created_at', function ($consolidated) {
            if (\Auth::user()->role_id == 2) return $consolidated->created_at->format('d/m/y');
            return ucfirst($consolidated->created_at->diffForHumans());
        })
        ->editColumn('closed_at', function ($consolidated) {
            if (\Auth::user()->role_id == 2) return $consolidated->closed_at->format('d/m/y');
            return ucfirst($consolidated->closed_at->diffForHumans());
        })
        ->editColumn('shippingstate', function ($consolidated) {
            $event = $consolidated->eventsUsers->last()->events;
            if ($event->id == 1) {
                $class = "info";
            } elseif ($event->id == 2) {
                $class = "warning";
            } elseif ($event->id == 3) {
                $class = "success";
            } elseif ($event->id == 4) {
                $class = "primary";
            } else {
                $class = "danger";
            }
            $last = $consolidated->eventsUsers->whereIn('event_id', [5,6,7,8])->count();
            if ($last == 4) {
                return '<span class="label label-' . $class . '"><i class="fa fa-check-square-o" aria-hidden="true"></i> OK</span>';
            }
            return '<span class="label label-' . $class . '">' . $event->event . '</span>';
        })
        ->addColumn('num_trackings', function ($consolidated) {
            return $consolidated->trackings->count();
        })
        ->addColumn('fullname', function ($consolidated) {
            return $consolidated->user->fullname();
        })
        ->filter(function ($query) use ($request) {
            if ($request->has('consolidated')) {
                $query->Where('number', 'like', "%{$request->consolidated}%");
            }
            if ($request->has('create_date')) {
                $query->Where('created_at', 'like', "%{$request->create_date}%");
            }
            if ($request->has('close_date')) {
                $query->Where('closed_at', 'like', "%{$request->close_date}%");
            }
        })
        ->make(true); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->index == 'create') {
            do {
                $num = 'IS' . rand(10000, 99999) . rand(100000, 999999);
                $test = Consolidated::where('number', '=', $num)->first();
            } while($test);
            $consolidado = Consolidated::create([
                'number' => $num,
                'user_id' => \Auth::user()->id,
                'shippingstate_id' => 1,
                'closed_at' => \Carbon::now()->addDay(5),
            ]);
            $cierre = $consolidado->closed_at->diffForHumans();
            $creacion = $consolidado->created_at->diffForHumans();
            $id = $consolidado->id;
            $user = $consolidado->user;
            EventsUsers::create([
                'consolidated_id' => $id,
                'event_id' => 1,
            ]);
            return response()->json(compact('creacion', 'cierre', 'id', 'user'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consolidated = Consolidated::findOrFail($id);
        $consolidated->user;
        $consolidated->event = $consolidated->eventsUsers->last()->events->event;
        $consolidated->trackings;
        $consolidated->sum_total = $consolidated->trackings->sum('price');
        $consolidated->close = $consolidated->closed_at->diffForHumans();
        $consolidated->open = $consolidated->created_at->diffForHumans();
        return response()->json($consolidated);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->to('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consolidated = Consolidated::findOrFail($id);
        $consolidated->trackings->each(function ($t) {
            $t->eventsUsers->each(function ($e) {
                $e->delete();
            });
            return $t->delete();
        });
        $consolidated->delete();
        return response()->json($consolidated);
    }

    /**
     * restaura el recurso especificado desde el almacenamiento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $consolidated = Consolidated::withTrashed()->findOrFail($id);
        $tracking = Tracking::where('consolidated_id', '=', $consolidated->id)
        ->withTrashed();
        $tracking->each(function ($t) {
            $events = EventsUsers::where('tracking_id', '=', $t->id)
            ->withTrashed();
            $events->each(function ($e) {
                $e->restore();
            });
            return $t->restore();
        });
        $consolidated->restore();
        return response()->json($consolidated);
    }

    /**
     * return the data for register.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $distributors = Distributor::orderBy('name', 'ASC')->get();
        $states = Events::where('type', '=', 1)->pluck('event', 'id');
        return response()->json(compact('distributors', 'states'));
    }

    /**
     * extiende el tiempo en espera del consolidado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function extend($id)
    {
        $consolidated = Consolidated::findOrFail($id);
        $extend = $consolidated->eventsUsers->where('event_id', '=', 2)->count();
        if ($extend < 2 || \Auth::user()->role_id == 1) {
            $consolidated->closed_at = $consolidated->closed_at->addDay(1);
            $consolidated->shippingstate_id = 2;
            EventsUsers::create([
                'consolidated_id' => $consolidated->id,
                'event_id' => 2,
            ]);
            $consolidated->save();
            return response()->json($consolidated);
        }
        return response()->json(['msg' => 'Ya el consolidado fue extendido.']);
    }

    /**
     * Formaliza un consolidado colocanco la fecha actual a la fecha de cierre.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function formalize($id)
    {
        $consolidated = Consolidated::findOrFail($id);
        if (! $consolidated->trackings->count()) return response(['msg' => 'El consolidado debe tener al menos un tracking.'], 422);
        $consolidated->closed_at = \Carbon::now();
        $consolidated->shippingstate_id = 3;
        EventsUsers::create([
            'consolidated_id' => $consolidated->id,
            'event_id' => 3,
        ]);
        $admins = \skyimport\User::where('role_id', '=', 1)->get();
        foreach ($admins as $admin) {
            \Mail::to($admin->email)->send(new \skyimport\Mail\Formalizado($consolidated));
        }
        return response()->json($consolidated->save());
    }

    public function dataEvents($id = null)
    {
        if ($id) {
            $trackings = Consolidated::findOrFail($id)->trackings;
        }
        $events = Events::where('type', '=', 2)
                ->where('id', '=', 12)
                ->orWhere('id', '=', 15)
                ->pluck('event', 'id');
        return response()->json(compact('trackings', 'events'));
    }

    public function bill(Request $request)
    {
        $this->validate($request, [
            'weight' => 'numeric|required',
            'bill' => 'numeric|required',
        ],[],[
            'weight' => 'peso',
            'bill' => 'precio',
        ]);
        $id = $request->consolidated;
        $consolidated = Consolidated::findOrFail($id);
        $consolidated->update(['shippingstate_id' => 6]);
        $consolidated->update($request->all());
        EventsUsers::create([
            'consolidated_id' => $id,
            'event_id' => 6,
        ]);
        $mail = $consolidated->user->email;
        if ($mail) {
            \Mail::to($mail)->send(new \skyimport\Mail\Factura($id));
        }
        return response()->json($consolidated);
    }

    public function addUserConsolidated($id)
    {
        $c = Consolidated::findOrFail($id);
        if ($c->user_id == request()->user_id) {
            return response()->json(['msg' => 'Este usuario pertenece a este consolidado.']);
        }
        $c->update(['user_id' => request()->user_id]);
        return response()->json($c);
    }
}
