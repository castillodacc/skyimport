<?php

namespace skyimport\Http\Controllers\ShippingManager;

use Illuminate\Http\Request;
use skyimport\Http\Controllers\Controller;
use skyimport\Models\Tracking;
use skyimport\Http\Requests\TrakingStoreRequest;
use skyimport\Models\EventsUsers;
use Yajra\DataTables\Datatables;

class TrackingController extends Controller
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
    if (!request()->ajax()) {
      if (\Auth::user()->role_id == 1) {
        return view('sendings.trackings');
      } else {
        return redirect()->to('/');
      }
    }

    $request = request();

    $query = Tracking::query()
    ->with(['distributor', 'shippingstate'])
    ->select(['trackings.*', ]);

    return (new Datatables)->of($query)
    ->addColumn('action', function ($tracking) {
      return '<a id="editTracking" tracking="'.$tracking->id.'" class="btn btn-primary btn-xs btn-flat col-xs-offset-4" href="#" data-toggle="tooltip" title="Editar"><span class="fa fa-edit"></span></a><a id="deleteTracking" tracking="'.$tracking->id.'" class="btn btn-danger btn-xs btn-flat" href="#" data-toggle="tooltip" title="Eliminar"><span class="fa fa-close"></span></a>';
    })
    ->editColumn('shippingstate.state', function ($tracking) {
      return $tracking->eventsUsers->last()->events->event;
    })
    ->editColumn('created_at', function ($tracking) {
      return $tracking->created_at->diffForHumans().'.';
    })
    ->filter(function ($query) use ($request) {
      $query->where('consolidated_id', '=', $request->consolidated_id);
    })
    ->make(true);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return redirect()->to('/');
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
    EventsUsers::create([
      'tracking_id' => $tracking->id,
      'event_id' => 7,
    ]);
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
    return redirect()->to('/');
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
    $tracking = Tracking::findOrFail($id)->update($request->all());
    return response()->json($tracking);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $tracking = Tracking::findOrFail($id);
    $tracking->eventsUsers->each(function ($e) {
      $e->delete();
    });
    $tracking->delete();
    return response()->json($tracking);
  }

  /**
   * restaura el recurso especificado desde el almacenamiento.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function restore($id)
  {
    $tracking = Tracking::withTrashed()->findOrFail($id)->restore();
    EventsUsers::where('tracking_id', '=', $tracking->id)
    ->where('consolidated_id', '=', null)->withTrashed()
    ->each(function ($e) {
      $e->delete();
    });
    $tracking->delete();
    return response()->json($consolidated);
  }

  public function all()
  {
    $query = Tracking::query()
    ->join('consolidateds', 'trackings.consolidated_id', '=', 'consolidateds.id')
    ->join('users', 'consolidateds.user_id', '=', 'users.id')
    ->select([
      'trackings.tracking as tracking_num',
      'consolidateds.number as consolidated_num',
      'users.id',
      'trackings.created_at',
      'trackings.shippingstate_id',
      'trackings.id',
      'trackings.consolidated_id'
    ]);

    return (new Datatables)->of($query)
    ->addColumn('user', function ($tracking) {
      return $tracking->consolidated->user->fullName();
    })
    ->addColumn('action', function ($tracking) {
      return '<label class="control control--checkbox">
      <input id="checkboxTracking" type="checkbox" tracking="'.$tracking->id.'">
      <div class="control__indicator"></div>
      </label>';
    })
    ->addColumn('event', function ($tracking) {
      return $tracking->eventsUsers->last()->events->event;
    })
    ->editColumn('created_at', function ($tracking) {
      return $tracking->created_at->diffForHumans();
    })
    ->filter(function ($query) {
      $request = request();
      $query->where('consolidateds.closed_at', '<', \Carbon::now());

      if (count($request->search['value']) > 0) {
        $query
        ->where('consolidateds.number', '=', $request->search['value'])
        ->orWhere('trackings.tracking', '=', $request->search['value']);
      }
      if ($request->has('created_at')) {
        $query->where('trackings.created_at', 'LIKE', "%{$request->created_at}%");
      }
      if ($request->has('event_id')) {
        $query->where('trackings.shippingstate_id', '=', $request->event_id);
      }
    })
    ->make(true);
  }

  public function addMassive($id, Request $request)
  {
    $trackings = $request->trackings;
    $errors = [];
    foreach ($trackings as $key) {
      $eventos = EventsUsers::where('tracking_id', '=', $key)
      ->where('event_id', '>=', $id)->count();
      if ($eventos) {
        $errors[] = Tracking::findOrFail($key)->tracking;
      } else {
        EventsUsers::create([
          'tracking_id' => $key,
          'event_id' => $id,
        ]);
        Tracking::findOrFail($key)->update(['shippingstate_id' => $id]);
        $id_consolidated = Tracking::findOrFail($key)->consolidated->id;
        \skyimport\Http\Controllers\NotificationController::changeStateOfConsolidated($id_consolidated, $id);
      }
    }
    return response()->json(compact('errors'));
  }
}
