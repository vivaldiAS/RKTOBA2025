@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Toko')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
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

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
<form action="./PostEditToko" method="post" enctype="multipart/form-data">
    @csrf
        <label>Nama Toko *</label>
        <input type="text" name="nama_merchant" class="form-control" value="{{$merchants->nama_merchant}}" required>

        <label>Deskripsi Toko *</label>
        <input type="text" name="deskripsi_toko" class="form-control" value="{{$merchants->deskripsi_toko}}" required>
        
        <label>Kontak Toko *</label>
        <input type="text" name="kontak_toko" class="form-control" value="{{$merchants->kontak_toko}}" onkeypress="return hanyaAngka(event)" required>
        
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
            <input id="uploadBtn1" type="file" name="foto_merchant" class="upload" accept="image/*"/>
            <input class="form-control" id="uploadFile1" value="{{$merchants->foto_merchant}}" disabled="disabled"/>
            <small class="form-text">Pastikan gambar yang anda masukkan dapat dilihat dengan jelas.</small>
        </div>
        
        <script>
            document.getElementById("uploadBtn1").onchange = function () {
                document.getElementById("uploadFile1").value = this.value;
            };
        </script>

        <button type="submit" class="btn btn-primary btn-round">
            <span>EDIT</span>
        </button>
    </form>
</div><!-- .End .tab-pane -->


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

