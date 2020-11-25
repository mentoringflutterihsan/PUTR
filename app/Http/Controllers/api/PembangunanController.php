<?php

namespace App\Http\Controllers\Api;

use App\Pembangunan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pembangunan as PembangunanResource;

class PembangunanController extends Controller
{
    /**
     * Get Pembangunan listing on Leaflet JS geoJSON data structure.
     *out
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $Pembangunan = Pembangunan::all();

        $geoJSONdata = $Pembangunan->map(function ($Pembangunan) {
            return [
                'type'       => 'Feature',
                'properties' => new PembangunanResource($Pembangunan),
                'geometry'   => [
                    'type'        => 'Point',
                    'coordinates' => [
                        $Pembangunan->longitude,
                        $Pembangunan->latitude,
                    ],
                ],
            ];
        });

        return response()->json([
            'type'     => 'FeatureCollection',
            'features' => $geoJSONdata,
        ]);
    }
}
