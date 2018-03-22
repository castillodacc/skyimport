<?php

namespace skyimport\Http\Controllers\ShippingManager;

use Illuminate\Http\Request;
use skyimport\Http\Controllers\Controller;
use skyimport\Models\Distributor;
use skyimport\Models\Consolidated;
use Yajra\DataTables\Datatables;
use skyimport\Models\Cstate;

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
        $query = Consolidated::query()
        ->with(['user', 'cstate']);
        return (new Datatables)->of($query)
        ->editColumn('created_at', function ($consolidated) {
            return $consolidated->created_at->diffForHumans();
        })
        ->editColumn('close_at', function ($consolidated) {
            return $consolidated->close_at->diffForHumans();
        })
        ->addColumn('action', function ($consolidated) {
            return '<input type="radio" name="consolidated" value="'.$consolidated->id.'" style="margin:0 50%">';
        })
        ->addColumn('fullname', function ($consolidated) {
            return $consolidated->user->name . ' ' . $consolidated->user->last_name;
        })->filter(function ($query) use ($request) {
            $query->where('cstate_id', '!=', 3);

            if ($request->has('consolidated')) {
                $query->orWhere('number', 'like', "%{$request->consolidated}%");
            }
            if ($request->has('create_date')) {
                $query->orWhere('created_at', 'like', "%{$request->create_date}%");
            }
            if ($request->has('close_date')) {
                $query->orWhere('close_at', 'like', "%{$request->close_date}%");
            }
        })->make(true); 
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
                $num = 'is' . rand(10000000000, 99999999999);
                $test = Consolidated::where('number', '=', $num)->first();
            }while($test);
            $consolidado = Consolidated::create([
                'number' => 'is' . rand(10000000000, 99999999999),
                'user_id' => \Auth::user()->id,
                'cstate_id' => 1,
                'close_at' => \Carbon::now()->addDay(3),
            ]);
            $cierre = $consolidado->close_at->diffForHumans();
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
        //
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
        $states = Cstate::all()->pluck('state', 'id');
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
        $consolidated->close_at = $consolidated->close_at->addDay(1);
        $consolidated->save();
        return response()->json($consolidated);
    }
}
