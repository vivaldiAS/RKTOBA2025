@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba -Experience| Beranda Rental Mobil ')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Toko</li>

@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
                <p>Detail Pemesanan Tiket</p>
            </div>
            <div class="col-md-12">
                <img
                    src="{{ asset('asset/Image/tiket_image/' . $pesanan->tiket_experience->gambar) }}"
                    alt="" width="300" class="mb-3">
            </div>
            <div class="col-md-12">
                <h6>Nama Tiket <span class="ml-3">: {{ $pesanan->tiket_experience->nama }}</span></h6>
                <h6>Tanggal Pemesanan <span class="ml-3">: {{ $pesanan->created_at }}</span></h6>
                <h6>Tanggal Berkunjung <span class="ml-3">: {{ $pesanan->tanggal_pemesanan }}</span></h6>
                <h6>Jumlah Tiket Anak <span class="ml-3">: {{ $pesanan->jumlah_anak }}</span></h6>
                <h6>Tanggal Tiket Dewasa <span class="ml-3">: {{ $pesanan->jumlah_dewasa }}</span></h6>
                <h6>Total Harga <span class="ml-3">: {{ $pesanan->total_harga }}</span></h6>
            </div>
        </div>
    </div>

@endsection
