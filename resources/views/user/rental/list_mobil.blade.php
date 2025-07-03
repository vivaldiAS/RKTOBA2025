@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba -Experience| Beranda Rental Mobil ')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection
@section('container')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5 rounded">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link" href="{{ url('/rental/mobil') }}">Beranda</a>
                            <a class="nav-link" href="{{ route('pesan_rental.index') }}">Pemesanan</a>
                            <a class="nav-link active" href="{{ url('/rental/list_mobil') }}">Mobil Anda</a>
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
                <a class="nav-link btn btn-outline-primary-2" href="{{ route('rental.add') }}">
                    <span>TAMBAH RENTAL MOBIL</span>
                    <i class="icon-long-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Nama Mobil</th>
                                <th>Nomor Polisi</th>
                                <th>Warna</th>
                                <th>Harga Sewa</th>
                                <th>Tipe Driver</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($list_mobil as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->nomor_polisi }}</td>
                                <td>{{ $data->warna }}</td>
                                <td>{{ $data->harga_sewa_per_hari }}</td>
                                <td>{{ $data->tipe_driver }}</td>
                                <td>
                                    <a href="{{ route('rental.detail', $data->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('rental.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="{{ route('rental.delete', $data->id) }}" class="btn btn-sm btn-danger hapus" id="btn-hapus">Hapus</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Data Mobil Tidak Ada</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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