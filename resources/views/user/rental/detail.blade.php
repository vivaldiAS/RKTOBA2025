@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba -Experience| Beranda Rental Mobil ')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>

@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('container')

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5 rounded">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href="{{ url('/rental/mobil') }}">Beranda</a>
                <a class="nav-link" href="#">Pemesanan</a>
                <a class="nav-link active" href="{{url('/rental/list_mobil')}}">Mobil Anda</a>
            </div>
        </div>
    </div>
</nav>

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <p>Detail Paket Mobil {{ $mobil->nama }}</p>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <img class="card-img-top img-mobil-list" src="{{ asset('asset/Image/rental_image/' . explode(',', $mobil->gambar)[0]) }}" alt="">
        </div>
        <div class="col-md-8">
            <h6>Nama Mobil <span class="ml-3">: {{ $mobil->nama }}</span></h6>
            <h6>Plat Mobil <span class="ml-3">: {{ $mobil->nomor_polisi }}</span></h6>
            <h6>Warna Mobil <span class="ml-3">: {{ $mobil->warna }}</span></h6>
            <h6>Mode Transmisi <span class="ml-3">: {{ $mobil->mode_transmisi }}</span></h6>
            <h6>Tipe Driver <span class="ml-3">: {{ $mobil->tipe_driver }}</span></h6>
            <h6>Lokasi <span class="ml-3">: {{ $mobil->lokasi }}</span></h6>
            <h6>Kapasitas Penumpang <span class="ml-3">: {{ $mobil->kapasitas_penumpang }}</span></h6>
            <h6>Harga Sewa Per hari <span class="ml-3">: {{ $mobil->harga_sewa_per_hari }}</span></h6>
        </div>
    </div>
</div>

@endsection
