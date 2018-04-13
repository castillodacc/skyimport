<?php

namespace skyimport\Http\Controllers\ShippingManager;

use Illuminate\Http\Request;
use skyimport\Http\Controllers\Controller;
use skyimport\Models\Distributor;
use skyimport\Models\Consolidated;
use Yajra\DataTables\Datatables;
use skyimport\Models\Shippingstate;
use skyimport\Models\Tracking;
use skyimport\Models\Events;
use skyimport\Models\EventsUsers;

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
        ->with(['user', 'Shippingstate'])
        ->select(['id', 'closed_at', 'user_id', 'created_at', 'number', 'shippingstate_id']);
        if ($request->c === 'abierto') {
            $object->where('closed_at', '>', \Carbon::now());
        } else {
            $object->where('closed_at', '<', \Carbon::now());
        }

        if (\Auth::user()->role_id == 2) {
            $object->where('user_id', '=', \Auth::user()->id);
        }

        return (new Datatables)->of($object)
        ->addColumn('action', function ($consolidated) {
            $name = (request()->c === 'abierto') ? 'consolidated' : 'consolidated2';
            $html = '<div class="btn-group btn-group-xs col-md-offset-1" role="toolbar">';
            $nameView = 'view-formalized';
            $nameEdit = 'edit-formalized';
            $nameDelete = 'delete-formalized';
            if (request()->c === 'abierto') {
                $nameView = 'viewConsolidated';
                $nameEdit = 'editConsolidated';
                $nameDelete = 'deleteConsolidated';
            }
            if (request()->c === 'abierto' &&
                ($consolidated->shippingstate_id == 1 || \Auth::user()->role_id === 1)) {
                $html .= '
                        <button id="extendConsolidated" type="button" class="btn btn-warning btn-flat" data-toggle="tooltip" data-placement="top" title="Extender un día el cierre" consolidated="' . $consolidated->id . '"><span class="fa fa-calendar-plus-o"></span></button>
                    ';
            }
            $html .= '
                    <button id="'.$nameView.'" type="button" class="btn btn-info btn-flat" data-toggle="tooltip" data-placement="top" title="Ver" consolidated="' . $consolidated->id . '"><span class="fa fa-eye"></span></button>
                ';
            if (request()->c === 'abierto' || \Auth::user()->role_id === 1) {
                $html .= '
                    <button id="'.$nameEdit.'" type="button" class="btn btn-primary btn-flat" data-toggle="tooltip" data-placement="top" title="Editar" consolidated="' . $consolidated->id . '"><span class="fa fa-edit"></span></button>
                ';
            }
            if (\Auth::user()->role_id === 1 || request()->c === 'abierto') {
                $html .= '
                    <button id="'.$nameDelete.'" type="button" class="btn btn-danger btn-flat" data-toggle="tooltip" data-placement="top" title="Eliminar" consolidated="' . $consolidated->id . '"><span class="fa fa-trash"></span></button>
                ';
            }
            $html .= '</div>';
            return $html;
        })
        ->editColumn('created_at', function ($consolidated) {
            return ucfirst($consolidated->created_at->diffForHumans().'.');
        })
        ->editColumn('closed_at', function ($consolidated) {
            return ucfirst($consolidated->closed_at->diffForHumans().'.');
        })
        ->editColumn('shippingstate', function ($consolidated) {
            if ($consolidated->shippingstate->id == 1) {
                $class = "info";
            } elseif ($consolidated->shippingstate->id == 2) {
                $class = "warning";
            } elseif ($consolidated->shippingstate->id == 3) {
                $class = "success";
            }
            return '<span class="label label-' . $class . '">'.$consolidated->shippingstate->state.'</span>';
        })
        ->addColumn('num_trackings', function ($consolidated) {
            return $consolidated->trackings->count();
        })
        ->addColumn('fullname', function ($consolidated) {
            return ucfirst($consolidated->user->name) . ' ' . ucfirst($consolidated->user->last_name);
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
            }while($test);
            $consolidado = Consolidated::create([
                'number' => $num,
                'user_id' => \Auth::user()->id,
                'shippingstate_id' => 1,
                'closed_at' => \Carbon::now()->addDay(3),
            ]);
            $cierre = $consolidado->closed_at->diffForHumans();
            $creacion = $consolidado->created_at->diffForHumans();
            $id = $consolidado->id;
            EventsUsers::create([
                'consolidated_id' => $id,
                'event_id' => 1,
            ]);
            return response()->json(compact('creacion', 'cierre', 'id'));
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
        $consolidated->Shippingstate;
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
        $distributors = Distributor::all()->pluck('name', 'id');
        $states = Shippingstate::where('ref_id', '=', 1)->pluck('state', 'id');
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
        if ($consolidated->shippingstate_id == 1 || \Auth::user()->role_id == 1) {
            $consolidated->closed_at = $consolidated->closed_at->addDay(1);
            $consolidated->shippingstate_id = 2;
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
        $consolidated->save();
        return response()->json($consolidated);
    }

    public function dataEvents($id)
    {
        $trackings = Consolidated::findOrFail($id)->trackings;
        $events = Events::where('type', '=', 2)->pluck('event', 'id');
        return response()->json(compact('trackings', 'events'));
    }
}
