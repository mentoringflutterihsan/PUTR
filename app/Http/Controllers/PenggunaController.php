<?php

namespace App\Http\Controllers;

use App\Pembangunan;
use Illuminate\Http\Request;
use DataTables;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function serverside(){
    //     $data=pembangunan::all();
    //     return DataTable::of($data)->make(true);
    // }
    public function index()
    {
        $penggunaQuery = Pembangunan::query();
        $penggunaQuery->where('name', 'like', '%'.request('q').'%');
        $pengguna = $penggunaQuery->paginate(25);
        // // $data=pembangunan::all();
        // // return Datatables::of($data)->make(true);
        // return view('pengguna.index');
        return view('pengguna.index', compact('pengguna'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $data=pembangunan::all();
        // return Datatables::of($data)->make(true);
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
    public function show(Pembangunan $pengguna)
    {
        return view('pengguna.show', compact('pengguna'));
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
