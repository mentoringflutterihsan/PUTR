@extends('layouts.app')

@section('content')
    <div class="mb-3">
        <div class="row">
            <div class="col-md-10">
                @can('create', new App\Pembangunan)
                    <a href="{{ route('pembangunan.create') }}" class="btn btn-primary">
                        Buat Data
                    </a>
                    <button type="button" class="btn btn-success" id="__btnExportExcel">
                        Export Excel
                    </a>
                @endcan
            </div>
            <div class="col-md-2">
                <select id="__filterTahun" class="form-control">
                    <option value="" disabled>- Pilih Tahun -</option>
                    @for ($tahun = date('Y'); $tahun >= date('Y') - 5; $tahun--)
                        <option value="{{ $tahun }}">
                            {{ $tahun }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered" id="__tablePembangunan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pekerjaan</th>
                                <th>Alamat Pekerjaan</th>
                                <th>Nilai Kontrak</th>
                                <th>Tahun</th>
                                <th>Panjang Pekerjaan</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach($pembangunan as $pembangunan)
                            <tr>
                                <td>{!! $pembangunan->name_link !!}</td>
                                <td>{{ $pembangunan->address }}</td>
                                <td>{{ $pembangunan->nilai_kontrak }}</td>
                                <td>{{ $pembangunan->latitude }}</td>
                                <td>{{ $pembangunan->longitude }}</td>
                                <td class="text-center">
                                    <a href="{{ route('pembangunan.show', $pembangunan) }}"
                                        id="show-pembangunan-{{ $pembangunan->id }}">Detail</a>
                                </td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('js/pembangunan/index.js?_=' . rand()) }}"></script>
@endpush