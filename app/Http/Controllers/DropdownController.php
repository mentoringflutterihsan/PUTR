<?php

namespace App\Http\Controllers;
use App\desa;
use DB;
use Illuminate\Http\Request;

class DropdownController extends Controller
{
    public function desa($id){
        // $desa=desa::where('kecamatan_id',$id)->pluck("name","id");
        // return json_encode($desa);
        // $data= "<option value=''>-Select Desa - </option>";
        // foreach ($desa as $value){
        //     $data .= "<option value='".$value->id."'>".$value->nama."</option>";
        // }
        // echo $data;


        // $desa = desa::where('kecamatan_id', $request->get('id'))->pluck('name', 'id');

        // return response()->json($desa);


        $desa = DB::table("desa")->where("kecamatan_id",$id)->pluck("nama","id");
        return json_encode($desa);
    }
}
