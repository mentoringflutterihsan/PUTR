@extends('layouts.app')

@section('title', 'Detail Pembangunan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Detail Pembangunan</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <td>Nama Pekerjaan</td>
                            <td>{{ $pembangunan->name }}</td>
                        </tr>
                        <tr>
                            <td>Nilai Kontrak</td>
                            <td>@currency($pembangunan->nilai_kontrak)</td>
                        </tr>
                        <tr>
                            <td>Latitude</td>
                            <td>{{ $pembangunan->latitude }}</td>
                        </tr>
                        <tr>
                            <td>Longtitude</td>
                            <td>{{ $pembangunan->longitude }}</td>
                        </tr>
                        <tr>
                            <td>Lokasi</td>
                            <td>{{ $pembangunan->address}}</td>
                        </tr>
                        <tr>
                            <td>Panjang Pekerjaan</td>
                            <td>{{ $pembangunan->panjang_pekerjaan}}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $pembangunan)
                <a href="{{ route('pembangunan.edit', $pembangunan) }}" id="edit-pembangunan-{{ $pembangunan->id }}"
                    class="btn btn-warning">Edit Pembangunan</a>
                @endcan
                @Auth
                <a href="{{ route('pembangunan.index') }}" class="btn btn-link">Kembali</a>
                @else
                <a href="{{ route('pembangunan_map.index') }}" class="btn btn-link">Kembali ke index</a>
                @endauth
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ trans('pembangunan.location') }}</div>
            @if ($pembangunan->coordinate)
            <div class="card-body" id="mapid"></div>
            @else
            <div class="card-body">Kordinat</div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin="" />

<style>
    #mapid {
        height: 400px;
    }
</style>
@endsection
@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>

<script>
    var map = L.map('mapid').setView([{{ $pembangunan->latitude }}, {{ $pembangunan->longitude }}], {{ config('leaflet.detail_zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([{{ $pembangunan->latitude }}, {{ $pembangunan->longitude }}]).addTo(map)
        .bindPopup('{!! $pembangunan->map_popup_content !!}');
</script>
@endpush