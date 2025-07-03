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

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <form action="./PostVerifikasi" method="post" enctype="multipart/form-data">
    @csrf
        <label>Foto KTP *</label>
        <div class="fileUpload">
            <input id="uploadBtn1" type="file" name="foto_ktp" class="upload" accept="image/*" required/>
            <input class="form-control" id="uploadFile1" placeholder="Pilih Foto..." disabled="disabled"/>
            <small class="form-text">Pastikan gambar yang anda masukkan dapat dilihat dengan jelas.</small>
        </div>

        <label>Foto Selfie bersama KTP *</label>
        <div class="fileUpload">
            <input id="uploadBtn2" type="file" name="ktp_dan_selfie" class="upload" accept="image/*" required/>
            <input class="form-control" id="uploadFile2" placeholder="Pilih Foto..." disabled="disabled"/>
            <small class="form-text">Pastikan gambar yang anda masukkan dapat dilihat dengan jelas.</small>
        </div>

        <script>
            document.getElementById("uploadBtn1").onchange = function () {
                document.getElementById("uploadFile1").value = this.value;
            };
            document.getElementById("uploadBtn2").onchange = function () {
                document.getElementById("uploadFile2").value = this.value;
            };
        </script>

        <button type="submit" class="btn btn-primary btn-round">
            <span>KIRIM</span>
        </button>
    </form>
</div><!-- .End .tab-pane -->


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

