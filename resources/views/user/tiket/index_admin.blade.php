@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba -Experience| Beranda Rental Mobil ')
<style>
    .responsive-table {
        width: 100%;
        overflow-x: auto;
    }

    .responsive-table th,
    .responsive-table td {
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .responsive-table thead {
            display: none;
        }

        .responsive-table tbody tr {
            display: block;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .responsive-table tbody td {
            display: block;
            text-align: right;
            font-weight: bold;
            border-bottom: none;
        }

        .responsive-table tbody td::before {
            content: attr(data-label);
            float: left;
            text-transform: uppercase;
            font-weight: normal;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection
@section('container')
<div class="row">
    <div class="col-md-12">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5 rounded">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link" href="">Beranda</a>
                        <a class="nav-link" href="{{ route('pesan_tiket.index') }}">Pemesanan</a>
                        <a class="nav-link active" href="{{ url('/tiket/admin') }}">Tiket Anda</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
            <p>Tambahkan produk anda</p>
            <a class="nav-link btn btn-outline-primary-2" href="{{ route('tiket.add') }}">
                <span>TAMBAH TIKET</span>
                <i class="icon-long-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-stripped responsive-table">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Lokasi</th>
                            <th>Jenis Tiket</th>
                            <th>Jam Operasional</th>
                            <th>Harga Anak</th>
                            <th>Harga Dewasa</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->lokasi }}</td>
                            <td>{{ $item->jenis_tiket }}</td>
                            <td>{{ $item->jam_operasional }}</td>
                            <td>{{ $item->harga_anak }}</td>
                            <td>{{ $item->harga_dewasa }}</td>
                            <td>
                                <a href="{{ route('tiket.detail', $item->id) }}" class="btn btn-info">Detail</a>
                                <a href="{{ route('tiket.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('tiket.delete', $item->id) }}" class="btn btn-danger" id="btn-hapus">Hapus</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Data Tiket Tidak Ada</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script>
    const form = document.getElementById('hapus');
    const button = document.getElementById('btn-hapus');

    button.addEventListener('click', (event) => {
        event.preventDefault(); // Mencegah browser mengirimkan form secara default

        form.submit(); // Mengirimkan form
    });
</script>
@endsection
