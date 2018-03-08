<?php

namespace skyimport\Http\Controllers\Admin;

use Illuminate\Http\Request;
use skyimport\Http\Controllers\Controller;
use skyimport\Http\Requests\ { UserStoreRequest, UserUpdateRequest };
use skyimport\User;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('ajax')->except(['index', 'profile']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!request()->ajax()) return view('users.user');

        return;
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
     * @param  \skyimport\Http\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        return $request->validated();
        $user = User::create($request->validated());
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
        $countries = \DB::table('countries')
                    ->orderBy('id', 'asc')
                    ->get();
        return response()->json(compact('user', 'countries'));
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
     * @param  \skyimport\Http\Requests\UserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        if($request->id == 1) return response(['errors' => 'Error al modificar usuario'], 422);
        $user = User::findOrFail($id)->update($request->all());
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id === 1) return response(['error' => 'Error al modificar usuario'], 422);
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
        return view('users.profile', compact('user'));
    }
}
