@extends('layouts.app')

@section('title', 'Tambah Program')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Tambah Program</div>
            <form method="POST" action="{{ route('pembangunan.store') }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Nama Pekerjaan</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                            name="name" value="{{ old('name') }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="nilai_kontrak" class="control-label">Nilai Kontrak</label>
                        <input id="nilai_kontrak"
                            class="form-control{{ $errors->has('nilai_kontrak') ? ' is-invalid' : '' }}"
                            name="nilai_kontrak" required>
                        {!! $errors->first('nilai_kontrak', '<span class="invalid-feedback"
                            role="alert">:message</span>') !!}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="control-label">latitude</label>
                                <input id="latitude" type="text"
                                    class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}"
                                    name="latitude" value="{{ old('latitude', request('latitude')) }}" required>
                                {!! $errors->first('latitude', '<span class="invalid-feedback"
                                    role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">Longtitude
                                </label>
                                <input id="longitude" type="text"
                                    class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}"
                                    name="longitude" value="{{ old('longitude', request('longitude')) }}" required>
                                {!! $errors->first('longitude', '<span class="invalid-feedback"
                                    role="alert">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <select name="kecamatan" class="form-control" style="width:250px">
                            <option value="">- Pilih Kecamatan -</option>
                            @foreach ($kecamatan as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="desa" id="desa" class="form-control">
                            <option value="">- Pilih Desa -</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="lokasi" class="control-label">Lokasi</label>
                        <input id="lokasi" type="text"
                            class="form-control{{ $errors->has('lokasi') ? ' is-invalid' : '' }}" name="lokasi"
                            required>
                        {!! $errors->first('lokasi', '<span class="invalid-feedback" role="alert">:message</span>')
                        !!}
                    </div>
                    <div class="form-group">
                        <label for="panjang_pekerjaan" class="control-label">Panjang Pekerjaan</label>
                        <input id="panjang_pekerjaan"
                            class="form-control{{ $errors->has('panjang_pekerjaan') ? ' is-invalid' : '' }}"
                            name="panjang_pekerjaan" required>
                    </div>
                    {{-- <div id="mapid"></div> --}}
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('pembangunan.create') }}" class="btn btn-success">
                    <a href="{{ route('pembangunan.index') }}" class="btn btn-link">cencel</a>
                </div>
            </form>
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
        height: 300px;
    }
</style>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script src="{{ asset('js/pembangunan/create.js?_=' . rand()) }}"></script>

{{-- <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>
<script>
    var mapCenter = [{{ request('latitude', config('leaflet.map_center_latitude')) }},
{{ request('longitude', config('leaflet.map_center_longitude')) }}];
var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.zoom_level') }});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var marker = L.marker(mapCenter).addTo(map);
function updateMarker(lat, lng) {
marker
.setLatLng([lat, lng])
.bindPopup("Your location : " + marker.getLatLng().toString())
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
</script> --}}

@endpush