@extends('layouts.app')

@section('title', 'Tambah Program')

@section('content')

<div class="card">
    <div class="card-body">
        <form method="post" action="{{route('desa.store')}}">
            <label for="nama_desa"> nama desa</label>
            <input type="text" name="nama_desa" id="nama_desa">
            <label for="luas_wilayah"> luas wilayah</label>
            <input type="number" name="luas_wilayah" id="luas_wilayah                                                                                           ">
        </form>
    </div>
</div>
@endsection