<?php

namespace App\Http\Controllers;

use App\pembangunan;
use App\kecamatan;


use Illuminate\Http\Request;
use App\Exports\PembangunanExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use DataTables;

class PembangunanController extends Controller
{
    /**
     * Display a listing of the pembangunan.
     *
     * @return \Illuminate\View\View
     */
    // public function ServerSide(){

    //     $data=pembangunan::all();
    //     return DataTable::of($data)->make(true);
    // }
    public function index(Request $request)
    {
 
        $pembangunan = pembangunan::all();
    
        return view('pembangunan.index', compact('pembangunan'));
        // return view('pembangunan.index');
    }

    /**
     * Show the form for creating a new pembangunan.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new pembangunan);
        $kecamatan=kecamatan::pluck('nama','id');
        return view('pembangunan.create',['kecamatan'=>$kecamatan,]);
    }

    /**
     * Store a newly created pembangunan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', new pembangunan);

        $newpembangunan = $request->validate([
            'name'      => 'required|max:60',
            'nilai_kontrak'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
            'lokasi'      => 'required|max:60',
            'panjang_pekerjaan' => 'required|max:60',
            
        ]);
    
        $pembangunan = pembangunan::create($newpembangunan);

        return redirect()->route('pembangunan.show', $pembangunan);
    }

    
    /**
     *
     * @param  \App\pembangunan  $pembangunan
     * @return \Illuminate\View\View
     */
    public function show(pembangunan $pembangunan)
    {
        return view('pembangunan.show', compact('pembangunan'));
    }

    /**
     * Show the form for editing the specified pembangunan.
     *
     * @param  \App\pembangunan  $pembangunan
     * @return \Illuminate\View\View
     */
    public function edit(pembangunan $pembangunan)
    {
        $this->authorize('update', $pembangunan);

        return view('pembangunan.edit', compact('pembangunan'));
    }

    /**
     * Update the specified pembangunan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pembangunan  $pembangunan
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, pembangunan $pembangunan)
    {
        $this->authorize('update', $pembangunan);

        $pembangunanData = $request->validate([
            'name'      => 'required|max:60',
            'nilai_kontrak'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
            'lokasi'      => 'required|max:60',
            'panjang_pekerjaan' => 'required|max:60',
            'volume'      => 'required|max:60',
        ]);
        $pembangunan->update($pembangunanData);

        return redirect()->route('pembangunan.show', $pembangunan);
    }

    /**
     * Remove the specified pembangunan from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pembangunan  $pembangunan
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, pembangunan $pembangunan)
    {
        $this->authorize('delete', $pembangunan);

        $request->validate(['pembangunan_id' => 'required']);

        if ($request->get('pembangunan_id') == $pembangunan->id && $pembangunan->delete()) {
            return redirect()->route('pembangunan.index');
        }

        return back();
    }
    public function export_excel()
	{
		return Excel::download(new PembangunanExport, 'pembangunan.xlsx');
    }
   
}
