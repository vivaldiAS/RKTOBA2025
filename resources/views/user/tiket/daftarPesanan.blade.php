@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba -Experience| Beranda Rental Mobil ')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>

@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('container')

<div class="row">
    <div class="col-md-12">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5 rounded">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link" href="">Beranda</a>
                        <a class="nav-link active" href="{{ route('pesan_tiket.index') }}">Pemesanan</a>
                        <a class="nav-link" href="{{ url('/tiket/admin') }}">Tiket Anda</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
        <div class="col-md-12">
            <div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
                <h6>Daftar Pesanan Tiket</h6>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive-xl">
                <table class="table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Tanggal Berkunjung</th>
                            <th>Jumlah Tiket Anak</th>
                            <th>Jumlah Tiket Dewasa</th>
                            <th>Total Harga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list_pesanan as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{date('d F Y', strtotime($data->created_at))}}</td>
                            <td>{{date('d F Y', strtotime($data->tanggal_pemesanan))}}</td>
                            <td>{{$data->jumlah_anak}}</td>
                            <td>{{$data->jumlah_dewasa}}</td>
                            <td>{{$data->total_harga}}</td>
                            <td>
                                <a href="{{ route('pesananTiket.detail', $data->id) }}" class="btn btn-sm btn-info">Detail</a>
                                {{-- <a href="{{ route('pesananRental.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('pesananRental.delete', $data->id) }}" class="btn btn-sm btn-danger hapus" id="btn-hapus">Hapus</a> --}}
                            </td>
                            @empty
                            <td colspan="7" class="text-center">Belum ada pesanan mobil</td>
                            @endforelse
                        </tr>
                    </tbody>
                </table>
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
