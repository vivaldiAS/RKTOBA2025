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
        width:200%;
    }
</style>

@section('container')
<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <form action="../PostTambahProduk" id="formProduct" method="post" enctype="multipart/form-data">
    @csrf
        <label>Pilih Kategori *</label>
        <div class="fileUpload">
            <select class="form-control" id="select_category" name="kategori_produk_id" required>
                <option selected disabled value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{$category->category_id}}">{{$category->nama_kategori}}</option>
                @endforeach
            </select>
        </div>

        <label>Nama Produk *</label>
        <input type="text" name="product_name" class="form-control" required>
        
        <label>Deskripsi Produk *</label>
        <input type="text" name="product_description" class="form-control" required>
        
        <label>Harga *</label>
        <input type="number" name="price" class="form-control" required>
        
        <label>Gambar Produk *</label>
        <div id="product_image">
            <div class="fileUpload">
                <input id="uploadBtn1" type="file" name="product_image[]" class="upload" accept="image/*" required/>
                <input class="form-control" id="uploadFile1" placeholder="Pilih Foto (Gambar utama)" disabled="disabled"/>
            </div>
            <div class="fileUpload">
                <input id="uploadBtn2" type="file" name="product_image[]" class="upload" accept="image/*" required/>
                <input class="form-control" id="uploadFile2" placeholder="Pilih Foto..." disabled="disabled"/>
            </div>
            <div class="fileUpload">
                <input id="uploadBtn3" type="file" name="product_image[]" class="upload" accept="image/*" required/>
                <input class="form-control" id="uploadFile3" placeholder="Pilih Foto..." disabled="disabled"/>
            </div>
        </div>
        <small class="form-text" style="margin-top:-15px">Pilih Minimal 3 Gambar. Pastikan gambar yang anda masukkan dapat dilihat dengan jelas.</small>
        
        <div id="div_category_type_specifications">
            {{$div_category_type_specifications}}
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label>Berat *</label>
                <input type="number" name="heavy" class="form-control" min="1" required>
                <small class="form-text">Berat dihitung dalam gram (gr).</small>
            </div><!-- End .col-sm-6 -->

            <div class="col-sm-6">
                <label>Stok *</label>
                <input type="number" id="qty" name="stok" class="form-control" min="1" step="1" data-decimals="0" required>
            </div><!-- End .col-sm-6 -->
        </div><!-- End .row -->

        <button type="submit" class="btn btn-primary btn-round">
            <span>TAMBAH</span>
        </button>
    </form>
    
    <script>
        document.getElementById("uploadBtn1").onchange = function () {
            document.getElementById("uploadFile1").value = this.value;
        };

        document.getElementById("uploadBtn2").onchange = function () {
            document.getElementById("uploadFile2").value = this.value;
        };      

        document.getElementById("uploadBtn3").onchange = function () {
            document.getElementById("uploadFile3").value = this.value;

            let stre3;
            stre3 = "<div class='fileUpload'><input id='uploadBtn4' type='file' name='product_image[]' class='upload' accept='image/*'/><input class='form-control' id='uploadFile4' placeholder='Pilih Foto...' disabled='disabled'/></div>";
            $("#product_image").append(stre3);
            
            document.getElementById("uploadBtn4").onchange = function () {
                document.getElementById("uploadFile4").value = this.value;

                let stre4;
                stre4 = "<div class='fileUpload'><input id='uploadBtn5' type='file' name='product_image[]' class='upload' accept='image/*'/><input class='form-control' id='uploadFile5' placeholder='Pilih Foto...' disabled='disabled'/></div>";
                $("#product_image").append(stre4);
                
                document.getElementById("uploadBtn5").onchange = function () {
                    document.getElementById("uploadFile5").value = this.value;

                    let stre5;
                    stre5 = "<div class='fileUpload'><input id='uploadBtn6' type='file' name='product_image[]' class='upload' accept='image/*'/><input class='form-control' id='uploadFile6' placeholder='Pilih Foto...' disabled='disabled'/></div>";
                    $("#product_image").append(stre5);
                    
                    document.getElementById("uploadBtn6").onchange = function () {
                        document.getElementById("uploadFile6").value = this.value;        
                    };
                };
            };
        };
        
        function hanyaAngka(event) {
            var angka = (event.which) ? event.which : event.keyCode
            if ((angka < 48 || angka > 57) )
                return false;
            return true;
        }
    </script>
</div><!-- .End .tab-pane -->

<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

<script src="{{ URL::asset('asset/js/function_2.js') }}"></script>

<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

