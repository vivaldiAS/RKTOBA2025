@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba -Experience| Update Mobil ')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>

@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Rental</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('mobil.update', $rental->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Nama Mobil</label>
            <input type="text" name="nama" class="form-control" required value="{{ $rental->nama }}">

            <label>Plat Mobil</label>
            <input type="text" name="nomor_polisi" class="form-control" required value="{{ $rental->nomor_polisi }}">

            <label>Warna Mobil</label>
            <input type="text" name="warna" class="form-control" required value="{{ $rental->warna }}">

            <label>Mode Transmisi Mobil</label>
            <input type="text" name="mode_transmisi" class="form-control" required value="{{ $rental->mode_transmisi }}">

            <label>Tipe Driver</label>
            <input type="text" name="tipe_driver" class="form-control" required value="{{ $rental->tipe_driver }}">

            <label>Lokasi Mobil Anda</label>
            <input type="text" name="lokasi" class="form-control" required value="{{ $rental->lokasi }}">

            <label>Kapasitas Penumpang</label>
            <input type="number" name="kapasitas_penumpang" class="form-control" required value="{{ $rental->kapasitas_penumpang }}">

            <label>Harga</label>
            <input type="number" name="harga_sewa_per_hari" class="form-control" required value="{{ $rental->harga_sewa_per_hari }}">

            <label>Gambar *</label>
            <div id="service_image">
                @foreach ($rental->gambars() as $image)
                <div class="fileUpload">
                    <input type="file" name="service_image[]" class="upload" accept="image/*" />
                    <input class="form-control" value="{{ $image }}" disabled="disabled" />
                    <img width="200" src="{{ asset('asset/Image/rental_image/' . $image) }}">
                </div>
                @endforeach
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Rental</button>
                </div>
        </form>

        @endsection