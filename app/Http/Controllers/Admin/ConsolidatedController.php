<?php

namespace skyimport\Http\Controllers\Admin;

use Illuminate\Http\Request;
use skyimport\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

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
        if (!request()->ajax()) return view('sendings.manage');

        return (new Datatables)->of(User::query()->with(['country', 'role'])->select())
        ->addColumn('action', function ($user) {
            return '<input type="radio" name="user" style="margin: 0 50%;" value='.$user->id.'>';
        })->make(true);

        return Datatables::of(User::query())
        ->addColumn('action', function ($user) {
            return '<input type="radio" name="user" value='.$user->id.'>';
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
