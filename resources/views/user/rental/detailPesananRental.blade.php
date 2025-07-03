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
                            <a class="nav-link" href="{{ url('/rental/mobil') }}">Beranda</a>
                            <a class="nav-link" href="#">Pemesanan</a>
                            <a class="nav-link active" href="{{ url('/rental/list_mobil') }}">Mobil Anda</a>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
                <p>Detail Pemesanan Rental</p>
            </div>
            <div class="col-md-12">
                <img
                    src="{{ asset('asset/Image/rental_image/' . explode(',', $pesanan->mobil->gambar)[0]) }}"
                    alt="">
            </div>
            <div class="col-md-12">
                <h6>Nama Mobil <span class="ml-3">: {{ $pesanan->mobil->nama }}</span></h6>
                <h6>Plat Mobil <span class="ml-3">: {{ $pesanan->mobil->nomor_polisi }}</span></h6>
                <h6>Tanggal Pemesanan <span class="ml-3">: {{ $pesanan->tanggal_pemesanan }}</span></h6>
                <h6>Tanggal Mulai Sewa <span class="ml-3">: {{ $pesanan->tanggal_mulai_sewa }}</span></h6>
                <h6>Tanggal Akhir Sewa <span class="ml-3">: {{ $pesanan->tanggal_akhir_sewa }}</span></h6>
                <h6>Jumlah Hari Sewa <span class="ml-3">: {{ $pesanan->jumlah_hari_sewa }}</span></h6>
            </div>
        </div>
    </div>



@endsection
