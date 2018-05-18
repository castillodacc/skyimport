<?php

namespace skyimport\Http\Controllers\ShippingManager;

use Illuminate\Http\Request;
use skyimport\Http\Controllers\Controller;
use skyimport\Models\Tracking;
use skyimport\Http\Requests\TrackingStoreRequest;
use skyimport\Http\Requests\TrackingUpdateRequest;
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
    ->with(['distributor'])
    ->select(['trackings.*']);

    return (new Datatables)->of($query)
    ->addColumn('action', function ($tracking) {
      return '
        <div class="text-center">
          <a id="editTracking" tracking="'.$tracking->id.'" class="btn btn-primary btn-xs btn-flat" href="#"><span class="fa fa-pencil"></span> Editar</a> 
          <a id="deleteTracking" tracking="'.$tracking->id.'" class="btn btn-danger btn-xs btn-flat" href="#"><span class="fa fa-close"></span> Cancelar</a>
        </div>
        ';
    })
    ->editColumn('shippingstate_id', function ($tracking) {
      if (\Auth::user()->role_id == 1) {
        $event = $tracking->eventsUsers->last()->events->event;
        return $event;
      } else {
        $event = $tracking->eventsUsers->last()->events;
        if ($event->id > 12) {
          $text = 'Recibido en bodega - Miami';
        } else {
          $text = $event->event;
        }
        return $text;
      }
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
   * @param  \skyimport\Http\Requests\TrackingStoreRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(TrackingStoreRequest $request)
  {
    $existe = Tracking::where('tracking', '=', $request->tracking)
    ->where('distributor_id', '=', $request->distributor_id)
    ->where('consolidated_id', '=', $request->consolidated_id)
    ->value('id');
    if ($existe) return response()->json(['msg' => 'El Tracking Ya fue registrado.']);
    $tracking = Tracking::create($request->all());
    EventsUsers::create([
      'tracking_id' => $tracking->id,
      'event_id' => 11,
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
   * @param  \skyimport\Http\Requests\TrackingUpdateRequest  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(TrackingUpdateRequest $request, $id)
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
      'trackings.consolidated_id',
      'trackings.description'
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
    ->addColumn('description', function ($tracking) {
      return $tracking->description;
    })
    ->addColumn('event', function ($tracking) {
      return $tracking->eventsUsers->last()->events->event;
    })
    ->editColumn('created_at', function ($tracking) {
      return $tracking->created_at->diffForHumans();
    })
    ->filter(function ($query) {
      $request = request();
      $query->where('consolidateds.closed_at', '<', \Carbon::now())
      ->where('consolidateds.shippingstate_id', '<>', 10);

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
      $event_current = Tracking::find($key)
                      ->eventsUsers
                      ->last()
                      ->event_id;
      if ($event_current >= $id) {
        $t = Tracking::findOrFail($key);
        $errors[] = $t->tracking . ' / ' . $t->description;
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
