@extends('layouts.tampilan')
@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin="" />

<style>
    #mapid {
        min-height: 500px;
    }
</style>
@endsection
@section('content')

<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
            <i class="far fa-user"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4>Total Data</h4>
            </div>
            <div class="card-body" id="total_records">

            </div>
        </div>
    </div>
</div>

<div class=" col-md-12 col-12 col-sm-12">
    <div class="card">
        <div class="card-header">
            <h4>Statistics</h4>
        </div>
        <div class="form-group">
            <input type="text" name="search" id="search" placeholder="Enter country name" class="form-control">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Nilai Kontrak</th>
                            <th>Lokasi</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengguna as $pengguna)
                        <tr>
                            <td>{!! $pengguna->name_link !!}</td>
                            <td>@currency($pengguna->nilai_kontrak)</td>
                            <td>{{ $pengguna->lokasi }}</td>
                            <td class="text-center">
                                <a href="{{ route('pengguna.show', $pengguna) }}"
                                    id="show-pembangunan-{{ $pengguna->id }}">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class=" col-md-12 col-12 col-sm-12">
    <div class="card">
        <div class="card-header">
            <h4>MAP</h4>
        </div>
        <div class="card-body" id="mapid">
        </div>
    </div>
</div>

@endsection


@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>

<script>
    var map = L.map('mapid').setView([{{ config('leaflet.map_center_latitude') }}, {{ config('leaflet.map_center_longitude') }}], {{ config('leaflet.zoom_level') }});
    var baseUrl = "{{ url('/') }}";

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    axios.get('{{ route('api.pembangunan.index') }}')
    .then(function (response) { 
        console.log(response.data);
        L.geoJSON(response.data, {
            pointToLayer: function(geoJsonPoint, latlng) {
                return L.marker(latlng);
            }
        })
        .bindPopup(function (layer) {
            return layer.feature.properties.map_popup_content;
        }).addTo(map);
    })
    .catch(function (error) {
        console.log(error);
    });
</script>

@endpush