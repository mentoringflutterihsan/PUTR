<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css" />
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            PUPR
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <li class="nav-item"><a class="nav-link" href="{{ route('pembangunan_map.index') }}">Peta</a>
                </li>
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                </li>
                <li class="nav-item">
                    @if (Route::has('register'))
                    <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                    @endif
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pembangunan.index') }}">Data Pembangunan</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<main class="py-4 container">
    <div class="mb-3">
        <div class="">
            @can('create', new App\pembangunan)
            <a href={{route("pembangunan.create")}} class="btn btn-success">Buat Data</a>
            <a href="/export" class="btn btn-success my-3" target="_blank">EXPORT EXCEL</a>
            @endcan
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                        <div class="form-group">
                            <label for="q" class="control-label">Cari sesuatu</label>
                            <input placeholder="Ketik Disini" name="q" type="text" id="q" class="form-control mx-sm-2"
                                value="{{ request('q') }}">
                        </div>
                        <input type="submit" value="cari" class="btn btn-secondary">
                        <a href="{{ route('pembangunan.index') }}" class="btn btn-link">Reset</a>
                    </form>
                </div>
                <table class="table table-bordered" id="users-table">
                    <thead>
                        <tr>
                            <th>Nama Pekerjaan</th>
                            <th>Alamat Pekerjaan</th>
                            <th>Nilai Kontrak</th>
                            <th>Longtitude </th>
                            <th>Latitude </th>
                            <th>Panjang Pekerjaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembangunan as $pembangunan)
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
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
    $('#users-table').DataTable();
} );
</script>