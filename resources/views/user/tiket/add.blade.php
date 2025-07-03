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

    input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        width: 200%;
    }
</style>

@section('container')
<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <form action="{{route('create_tiket')}}" id="formProduct" method="post" enctype="multipart/form-data">
        @csrf
        <label>Nama Tiket</label>
        <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama tiket">

        <label>Lokasi</label>
        <input type="text" name="lokasi" class="form-control" required placeholder="Masukkan lokasi tempat/alamat tempat anda">

        <label>Jenis Tiket</label>
        <select name="jenis_tiket" id="" class="form-control">
            <option value="Museum">Museum</option>
            <option value="Kolam Renang">Kolam Renang</option>
        </select>

        <label>Waktu Operasional</label>
        <input type="text" name="jam_operasional" class="form-control" required placeholder="Jam operasional| Contoh: 08:00-17:00">

        <label>Harga Anak-Anak</label>
        <input type="text" name="harga_anak" class="form-control" required placeholder="Harga untuk Anak-anak">

        <label>Harga Dewasa</label>
        <input type="text" name="harga_dewasa" class="form-control" required placeholder="Harga untuk Dewasa">

        <label>Gambar *</label>
        <div id="gambar">
            <div class="fileUpload">
                <input id="uploadBtn1" type="file" name="gambar" class="upload" accept="image/*" required />
                <input class="form-control" id="uploadFile1" placeholder="Pilih Foto..." disabled="disabled" />
            </div>
        </div>
        <small class="form-text" style="margin-top:-15px">Pilih Gambar. Pastikan gambar yang anda masukkan dapat dilihat dengan jelas.</small>

        <button type="submit" class="btn btn-primary btn-round">
            <span>TAMBAH</span>
        </button>
    </form>
</div><!-- .End .tab-pane -->

@endsection