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
                        <a class="nav-link" href="{{ route('pesan_tiket.index') }}">Pemesanan</a>
                        <a class="nav-link active" href="{{ url('/tiket/admin') }}">Tiket Anda</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <p>Detail Paket {{ $tiket->nama }}</p>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <img class="card-img-top img-mobil-list" src="{{ asset('asset/Image/tiket_image/' . $tiket->gambar) }}" alt="">
        </div>
        <div class="col-md-8">
            <h6>Nama Tiket <span class="ml-3">: {{ $tiket->nama }}</span></h6>
            <h6>Lokasi <span class="ml-3">: {{ $tiket->lokasi }}</span></h6>
            <h6>Jenis Tiket <span class="ml-3">: {{ $tiket->jenis_tiket }}</span></h6>
            <h6>Jam Operasional <span class="ml-3">: {{ $tiket->jam_operasional }}</span></h6>
            <h6>Harga Tiket Anak <span class="ml-3">: {{ $tiket->harga_anak }}</span></h6>
            <h6>Harga Tiket Dewasa <span class="ml-3">: {{ $tiket->harga_dewasa }}</span></h6>
        </div>
    </div>
</div>

@endsection
