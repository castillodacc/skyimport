<?php

namespace skyimport\Http\Controllers\Admin;

use Illuminate\Http\Request;
use skyimport\Http\Controllers\Controller;
use skyimport\Http\Requests\ { UserStoreRequest, UserUpdateRequest, changePasswordRequest };
use skyimport\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Datatables;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['index', 'store', 'destroy', 'restore']);
        $this->middleware('ajax')->except(['index', 'profile']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!request()->ajax()) return view('users.users');

        $query = User::query()->with(['role'])
        ->select(['id', 'name', 'last_name', 'num_id', 'email', 'phone', 'role_id', 'state_id']);

        return (new Datatables)->of($query)
        ->addColumn('role.rol', function ($user) {
            if ($user->role->id == 1) {
                $class = "bg-green";
            } else {
                $class = "bg-primary";
            }
            return '<span class="label ' . $class . '">' . $user->role->rol . '</span>';
        })->addColumn('pais', function ($user) {
            if ($user->state == null) return '-';
            return $user->state->countrie->country;
        })->addColumn('action', function ($user) {
            return '
                    <div class="text-center">
                       
                         <button id="edit-user" type="button" class="btn btn-primary btn-flat btn-xs" user="'.$user->id.'"><span class="fa fa-pencil"></span> Editar</button>
                       
                        
                        <button id="delete-user" type="button" class="btn btn-danger btn-flat btn-xs" user="'.$user->id.'"><span class="fa fa-trash"></span> Eliminar</button>
                        
                    </div>
                ';
        })
        ->editColumn('fullname', function ($user) {
            return $user->fullname();
        })
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \skyimport\Http\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password2);
        $user = User::create($data);
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $user->state;
        $user['consolidateda'] = $user->consolidated->where('closed_at', '>', \Carbon::now())->count();
        $user['consolidatedc'] = $user->consolidated->where('closed_at', '<', \Carbon::now())->count();
        $countries = \DB::table('countries')->latest('id')->pluck('country', 'id');
        return response()->json(compact('user', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \skyimport\Http\Requests\UserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        if($id == 1) return response(['errors' => 'Error al modificar usuario'], 422);
        $data = $request->all();
        if( !empty($data['password2']) ){
            $this->validate($request, [
                'password2' => 'string|min:6|confirmed'
            ]);
            $data['password'] = bcrypt($request->password2);
        }
        unset($data['password2']);
        unset($data['password2_confirmation']);
        $user = User::findOrFail($id)->fill($data);
        return response()->json($user->save());
    }

    /**
     * Upload image 'avatar' from user.
     *
     * @param  \skyimport\Http\Requests\UserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveImage(Request $request, $id)
    {
        $this->validate($request, ['avatar' => 'image']);
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $ext = $request->avatar->getClientOriginalExtension();
            $name = $id.'.'.$ext;
            foreach (['.jpg','.jpeg','.png'] as $e) {
                if(\File::exists(public_path('/storage/app/' . $id . $e))){
                    \File::delete(public_path('/storage/app/' . $id . $e));
                }
            }
            \Storage::disk('local')->put($name,  \File::get($file));
        }
        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id == 1) return response(['error' => 'Error al modificar usuario'], 421);
        $user = User::findOrFail($id)->delete();
        return response()->json($user);
    }

    /**
     * Show the user's profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile($id = null)
    {
        if ($id) {
            $user = User::findOrFail($id);
        } else {
            $user = \Auth::user();
        }
        return view('users.profile', compact('user', 'id'));
    }

    /**
     * Change of password.
     *
     * @param \skyimport\Http\Requests\changePasswordRequest
     * @return \Illuminate\Http\Response
     */
    public function changePassword(changePasswordRequest $request)
    {
        $user = User::findOrFail(\Auth::user()->id)->fill([
            'password' => bcrypt($request->password)
        ]);
        return response()->json($user->save());
    }

    /**
     * Data for register of user.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $countries = \DB::table('countries')->latest('id')->select('id', 'country')->get();
        $roles = \DB::table('roles')->latest('id')->select('id', 'rol')->get();
        return response()->json(compact('countries', 'roles'));
    }

    public function dataStates($id)
    {
        $states = \DB::table('states')
        ->where('countrie_id', '=', $id)
        ->orderBy('state', 'ASC')
        ->pluck('state', 'id');
        return response()->json($states);
    }

    /**
     * restaura el recurso especificado desde el almacenamiento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if ($id == 1) return response(['error' => 'Error al modificar usuario'], 422);
        /* Indicamos que la busqueda se haga en los registros eliminados con withTrashed y restauramos el recurso */
        $user = User::withTrashed()->findOrFail($id)->restore();
        return response()->json($user);
    }
}