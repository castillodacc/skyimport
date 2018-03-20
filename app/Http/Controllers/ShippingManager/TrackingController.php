<?php

namespace skyimport\Http\Controllers\ShippingManager;

use Illuminate\Http\Request;
use skyimport\Http\Controllers\Controller;
use skyimport\Models\Tracking;
use skyimport\Http\Requests\TrakingStoreRequest;
use Yajra\DataTables\Datatables;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $query = Tracking::query()
                    ->with(['distributor'])
                    ->select(['trackings.id','trackings.description','trackings.tracking','trackings.distributor_id']);
        return (new Datatables)->of($query)
        ->addColumn('action', function ($tracking) {
            return '<a id="editTracking" tracking="'.$tracking->id.'" class="btn btn-primary btn-xs btn-flat" href="#" data-toggle="tooltip" title="Editar"><span class="fa fa-pencil"></span></a> <a id="deleteTracking" tracking="'.$tracking->id.'" class="btn btn-danger btn-xs btn-flat" href="#" data-toggle="tooltip" title="Eliminar"><span class="fa fa-close"></span></a>';
        })->filter(function ($query) use ($request) {
            $query->where('consolidated_id', '=', $request->consolidated_id);
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \skyimport\Http\Requests\TrakingStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrakingStoreRequest $request)
    {
        $existe = Tracking::where('tracking', '=', $request->tracking)
        ->where('distributor_id', '=', $request->distributor_id)
        ->where('consolidated_id', '=', $request->consolidated_id)
        ->value('id');
        if ($existe) return response()->json(['msg' => 'El Tracking Ya fue registrado.']);

        $tracking = Tracking::create($request->all());
        return response()->json($tracking);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tracking = Tracking::findOrFail($id);
        return response()->json($tracking);
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
        $tracking = Tracking::findOrFail($id)->delete();
        return response()->json($tracking);
    }
}
