<?php

namespace skyimport\Http\Controllers\ShippingManager;

use Illuminate\Http\Request;
use skyimport\Http\Controllers\Controller;
use skyimport\Models\Distributor;
use skyimport\Models\Consolidated;
use Yajra\DataTables\Datatables;
use skyimport\Models\Shippingstate;

class ConsolidatedController extends Controller
{
    public function __construct()
    {
        $this->middleware('ajax')->except(['index']);
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
            return '<input type="radio" name="consolidated" value="'.$consolidated->id.'" style="margin:0 50%">';
        })
        ->editColumn('created_at', function ($consolidated) {
            return $consolidated->created_at->diffForHumans().'.';
        })
        ->editColumn('closed_at', function ($consolidated) {
            return $consolidated->closed_at->diffForHumans().'.';
        })
        ->editColumn('shippingstate', function ($consolidated) {
            if ($consolidated->shippingstate->id == 1) {
                $class = "info";
            }
            return '<span class="label label-' . $class . '">'.$consolidated->shippingstate->state.'</span>';
        })
        ->addColumn('num_trackings', function ($consolidated) {
            return $consolidated->trackings->count();
        })
        ->addColumn('fullname', function ($consolidated) {
            return $consolidated->user->name . ' ' . $consolidated->user->last_name;
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consolidated = Consolidated::findOrFail($id)->delete();
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
        $consolidated->closed_at = $consolidated->closed_at->addDay(1);
        $consolidated->save();
        return response()->json($consolidated);
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
        $consolidated->save();
        return response()->json($consolidated);
    }
}
