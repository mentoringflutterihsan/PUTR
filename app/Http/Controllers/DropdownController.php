<?php

namespace App\Http\Controllers;
use App\Desa;
use Illuminate\Http\Request;

class DropdownController extends Controller
{
    /**
     * Get desa data by `kecamatan_id`
     *
     * @param int $kecamatan_id
     * @return mixed
     */
    public function getDesaByKecamatan($kecamatan_id){
        $desa = Desa::where('kecamatan_id', $kecamatan_id)
                    ->selectRaw('id, nama_desa AS text')
                    ->orderBy('nama_desa')
                    ->get();

        return response()->json($desa);
    }
}
