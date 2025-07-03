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
    <form action="{{ route('rental.update', $mobil->id)}}" id="formProduct" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <label>Nama Mobil</label>
        <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama mobil" value="{{ $mobil->nama }}">

        <label>Plat Mobil</label>
        <input type="text" name="nomor_polisi" class="form-control" required placeholder="Masukkan plat mobil" value="{{ $mobil->nomor_polisi }}">

        <label>Warna Mobil</label>
        <input type="text" name="warna" class="form-control" required placeholder="Masukkan warna mobil" value="{{ $mobil->warna }}">

        <label>Mode Transmisi Mobil</label>
        <input type="text" name="mode_transmisi" class="form-control" required placeholder="Masukkan Mode Transmisi (ex:Manual,Matic)" value="{{ $mobil->mode_transmisi }}">

        <label>Tipe Driver</label>
        <input type="text" name="tipe_driver" class="form-control" required placeholder="Masukkan Tipe Driver (ex:Tanpa Driver, Dengan Driver)" value="{{ $mobil->tipe_driver }}">

        <label>Lokasi Mobil Anda</label>
        <input type="text" name="lokasi" class="form-control" required placeholder="Lokasi Mobil Anda Berada" value="{{ $mobil->lokasi }}">

        <label>Kapasitas Penumpang</label>
        <input type="number" name="kapasitas_penumpang" class="form-control" required placeholder="Masukkan kapasitas penumpang mobil" value="{{ $mobil->kapasitas_penumpang }}">

        <label>Harga</label>
        <input type="number" name="harga_sewa_per_hari" class="form-control" required placeholder="Masukkan harga sewa per hari" value="{{ $mobil->harga_sewa_per_hari }}">

        <label>Gambar *</label>
        <div id="service_image">
            <div class="fileUpload">
                <input id="uploadBtn1" type="file" name="service_image[]" class="upload" accept="image/*" />
                <input class="form-control" id="uploadFile1" placeholder="Pilih Foto..." disabled="disabled" />
            </div>
            <div class="fileUpload">
                <input id="uploadBtn2" type="file" name="service_image[]" class="upload" accept="image/*" />
                <input class="form-control" id="uploadFile2" placeholder="Pilih Foto..." disabled="disabled" />
            </div>
            <div class="fileUpload">
                <input id="uploadBtn3" type="file" name="service_image[]" class="upload" accept="image/*" />
                <input class="form-control" id="uploadFile3" placeholder="Pilih Foto..." disabled="disabled" />
            </div>
        </div>
        <small class="form-text" style="margin-top:-15px">Pilih Minimal 3 Gambar. Pastikan gambar yang anda masukkan dapat dilihat dengan jelas.</small>

        <button type="submit" class="btn btn-primary btn-round">
            <span>TAMBAH</span>
        </button>
    </form>

    <script>
        document.getElementById("uploadBtn1").onchange = function() {
            document.getElementById("uploadFile1").value = this.value;
        };

        document.getElementById("uploadBtn2").onchange = function() {
            document.getElementById("uploadFile2").value = this.value;
        };

        document.getElementById("uploadBtn3").onchange = function() {
            document.getElementById("uploadFile3").value = this.value;

            let stre3;
            stre3 = "<div class='fileUpload'><input id='uploadBtn4' type='file' name='product_image[]' class='upload' accept='image/*'/><input class='form-control' id='uploadFile4' placeholder='Pilih Foto...' disabled='disabled'/></div>";
            $("#product_image").append(stre3);

            document.getElementById("uploadBtn4").onchange = function() {
                document.getElementById("uploadFile4").value = this.value;

                let stre4;
                stre4 = "<div class='fileUpload'><input id='uploadBtn5' type='file' name='product_image[]' class='upload' accept='image/*'/><input class='form-control' id='uploadFile5' placeholder='Pilih Foto...' disabled='disabled'/></div>";
                $("#product_image").append(stre4);

                document.getElementById("uploadBtn5").onchange = function() {
                    document.getElementById("uploadFile5").value = this.value;

                    let stre5;
                    stre5 = "<div class='fileUpload'><input id='uploadBtn6' type='file' name='product_image[]' class='upload' accept='image/*'/><input class='form-control' id='uploadFile6' placeholder='Pilih Foto...' disabled='disabled'/></div>";
                    $("#product_image").append(stre5);

                    document.getElementById("uploadBtn6").onchange = function() {
                        document.getElementById("uploadFile6").value = this.value;
                    };
                };
            };
        };

        function hanyaAngka(event) {
            var angka = (event.which) ? event.which : event.keyCode
            if ((angka < 48 || angka > 57))
                return false;
            return true;
        }
    </script>
</div><!-- .End .tab-pane -->

@endsection
