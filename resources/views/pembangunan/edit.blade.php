@extends('layouts.app')

@section('title', __('pembangunan.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $pembangunan)
        @can('delete', $pembangunan)
        <div class="card">
            <div class="card-header">Hapus Data</div>
            <div class="card-body">
                <label class="control-label text-primary">Nama Paket</label>
                <p>{{ $pembangunan->name }}</p>
                <label class="control-label text-primary">Alamat </label>
                <p>{{ $pembangunan->nilai_kontrak }}</p>
                <label class="control-label text-primary">Latitude</label>
                <p>{{ $pembangunan->latitude }}</p>
                <label class="control-label text-primary">Longtitude</label>
                <p>{{ $pembangunan->longitude }}</p>
                {!! $errors->first('pembangunan_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
            </div>
            <hr style="margin:0">
            <div class="card-body text-danger">Konfirmasi</div>
            <div class="card-footer">
                <form method="POST" action="{{ route('pembangunan.destroy', $pembangunan) }}" accept-charset="UTF-8"
                    onsubmit="return confirm(&quot;Hapus Data&quot;)" class="del-form float-right"
                    style="display: inline;">
                    {{ csrf_field() }} {{ method_field('delete') }}
                    <input name="pembangunan_id" type="hidden" value="{{ $pembangunan->id }}">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
                <a href="{{ route('pembangunan.edit', $pembangunan) }}" class="btn btn-link">Tutup</a>
            </div>
        </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">Ubah Data</div>
            <form method="POST" action="{{ route('pembangunan.update', $pembangunan) }}" accept-charset="UTF-8">
                {{ csrf_field() }} @method("PATCH")

                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Nama Paket</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                            name="name" value="{{ old('name', $pembangunan->name) }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="nilai_kontrak" class="control-label">Nilai Kontrak</label>
                        <input id="nilai_kontrak"
                            class="form-control{{ $errors->has('nilai_kontrak') ? ' is-invalid' : '' }}"
                            name="nilai_kontrak" required>
                    </div>
                    <div class="form-group">
                        <label for="lokasi" class="control-label">Lokasi</label>
                        <input id="lokasi"
                            class="form-control{{ $errors->has('lokasi') ? ' is-invalid' : '' }}"
                            name="lokasi" required>
                    </div>
                    <div class="form-group">
                        <label for="volume" class="control-label">Volume</label>
                        <input id="volume"
                            class="form-control{{ $errors->has('volume') ? ' is-invalid' : '' }}"
                            name="volume" required>
                    </div>
                    <div class="form-group">
                        <label for="panjang_pekerjaan" class="control-label">Panjang Pekerjaan</label>
                        <input id="volume"
                            class="form-control{{ $errors->has('panjang_pekerjaan') ? ' is-invalid' : '' }}"
                            name="panjang_pekerjaan" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="control-label">Latitude</label>
                                <input id="latitude" type="text"
                                    class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}"
                                    name="latitude" value="{{ old('latitude', $pembangunan->latitude) }}" required>
                                {!! $errors->first('latitude', '<span class="invalid-feedback"
                                    role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">Longtitude</label>
                                <input id="longitude" type="text"
                                    class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}"
                                    name="longitude" value="{{ old('longitude', $pembangunan->longitude) }}" required>
                                {!! $errors->first('longitude', '<span class="invalid-feedback"
                                    role="alert">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div id="mapid"></div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="Ubah Data" class="btn btn-success">
                    <a href="{{ route('pembangunan.show', $pembangunan) }}" class="btn btn-link">Tutup </a>
                    @can('delete', $pembangunan)
                    <a href="{{ route('pembangunan.edit', [$pembangunan, 'action' => 'delete']) }}"
                        id="del-pembangunan-{{ $pembangunan->id }}" class="btn btn-danger float-right">Hapus</a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin="" />

<style>
    #mapid {
        height: 300px;
    }
</style>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>
<script>
    var mapCenter = [{{ $pembangunan->latitude }}, {{ $pembangunan->longitude }}];
    var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.detail_zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker(mapCenter).addTo(map);
    function updateMarker(lat, lng) {
        marker
        .setLatLng([lat, lng])
        .bindPopup("Your location :  " + marker.getLatLng().toString())
        .openPopup();
        return false;
    };

    map.on('click', function(e) {
        let latitude = e.latlng.lat.toString().substring(0, 15);
        let longitude = e.latlng.lng.toString().substring(0, 15);
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
        updateMarker(latitude, longitude);
    });

    var updateMarkerByInputs = function() {
        return updateMarker( $('#latitude').val() , $('#longitude').val());
    }
    $('#latitude').on('input', updateMarkerByInputs);
    $('#longitude').on('input', updateMarkerByInputs);
</script>
@endpush