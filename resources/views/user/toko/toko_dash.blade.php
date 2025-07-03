@extends('user/layout/main_dash')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

<style>
    .fileUpload {
        position: relative;
        overflow: hidden;
        padding-bottom: 5px;
    }
    
    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        width:200%;
    }
</style>

@section('container')

@if($cek_verified && $cek_rekening && $cek_merchant_verified)
<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <form action="./MasukToko" method="post" enctype="multipart/form-data">
    @csrf
        <label>Password *</label>
        <input type="password" name="password" class="form-control" required>
        <small class="form-text">Pastikan password yang anda masukkan benar.</small>

        <button type="submit" class="btn btn-outline-primary-2">
            <span>MASUK</span>
        </button>
    </form>
</div><!-- .End .tab-pane -->

@elseif($cek_verified && $cek_rekening && $cek_merchant)
<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <p>Menunggu toko anda diverifikasi.</p>
</div><!-- .End .tab-pane -->

@elseif($cek_verified && $cek_rekening)
<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
<form action="./PostTambahToko" method="post" enctype="multipart/form-data">
    @csrf
        <label>Nama Toko *</label>
        <input type="text" name="nama_merchant" class="form-control" required>

        <label>Deskripsi Toko *</label>
        <input type="text" name="deskripsi_toko" class="form-control" required>
        
        <label>Kontak Toko *</label>
        <input type="text" name="kontak_toko" class="form-control" onkeypress="return hanyaAngka(event)" required>
        
        <script>
            function hanyaAngka(event) {
                var angka = (event.which) ? event.which : event.keyCode
                if ((angka < 48 || angka > 57) )
                    return false;
                return true;
            }
        </script>
        
        <label>Foto Toko *</label>
        <div class="fileUpload">
            <input id="uploadBtn1" type="file" name="foto_merchant" class="upload" accept="image/*" required/>
            <input class="form-control" id="uploadFile1" placeholder="Pilih Foto..." disabled="disabled"/>
            <small class="form-text">Pastikan gambar yang anda masukkan dapat dilihat dengan jelas.</small>
        </div>
        
        <script>
            document.getElementById("uploadBtn1").onchange = function () {
                document.getElementById("uploadFile1").value = this.value;
            };
        </script>

        <button type="submit" class="btn btn-primary btn-round">
            <span>TAMBAH</span>
        </button>
    </form>
</div><!-- .End .tab-pane -->

@elseif($cek_verified)
<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <p>Akun anda telah diverifikasi.</p>
    <p>Lanjutkan dengan mengisi data rekening anda.</p>
    <a class="nav-link btn btn-outline-primary-2" href="./rekening">
        <span>ISI DATA</span>
        <i class="icon-long-arrow-right"></i>
    </a>
</div><!-- .End .tab-pane -->

@elseif($cek_verifikasi)
<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <p>Menunggu akun anda diverifikasi.</p>
</div><!-- .End .tab-pane -->

@else
<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <p>Akun anda belum terverifikasi</p>
    <a class="nav-link btn btn-outline-primary-2" href="./verifikasi">
        <span>ISI DATA</span>
        <i class="icon-long-arrow-right"></i>
    </a>
</div><!-- .End .tab-pane -->

@endif


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

