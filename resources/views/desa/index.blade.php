@extends('layouts.app')

@section('title','nama desa')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">

            <table class="table table-sm table-responsive-sm">
                <thead>
                    <tr>
                        <th class="text-center">No </th>
                        <th>Desa</th>
                        <th>Luas Wiilayah </th>
                        <th>nama kecamatan</th>

                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0;?>
                    @foreach($desa as $item)
                    <?php $no++ ;?>
                    <tr>
                        <td class="text-center">{{ $no }}</td>
                        <td>{{$item->nama_desa}}</td>
                        <td>{{$item->luas_wilayah}}</td>

                        <td>{{$item->kecamatan->nama_kecamatan}}</td>



                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection