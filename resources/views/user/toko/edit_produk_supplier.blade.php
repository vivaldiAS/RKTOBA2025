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
    <form action="../PostEditProdukSupplier/{{$product_id}}" id="formProduct" method="post" enctype="multipart/form-data">
    @csrf
        <label>Kategori :</label>
        <label>{{$product->nama_kategori}}</label><br>
        
        <label>Deskripsi :</label>
        <label>
            @if($jumlah_product_specifications == 0)

            @else
            {{$product_specifications->nama_spesifikasi}},
            @endif
        </label><br>

        <div class="mb-1"></div>

        <label>Nama Produk *</label>
        <input type="text" name="product_name" class="form-control" value="{{$product->product_name}}" required>
        
        <label>Deskripsi Produk *</label>
        <input type="text" name="product_description" class="form-control" value="{{$product->product_description}}" required>
        
        <label>Harga *</label>
        <input type="text" name="price" class="form-control" onkeypress="return hanyaAngka(event)" value="{{$product->price}}" required>
        
        <label>Gambar Produk Lama</label>
        <div class="row">
        @foreach($product_images as $product_image1)
            @if($product_image1->product_id == $product->product_id)
            <div class="col-4 col-md-4 col-lg-4 col-xl-2">
                    <img src="../asset/u_file/product_image/{{$product_image1->product_image_name}}" alt="Product image" class="product-image">
                </div>
            @endif
        @endforeach
        </div>
            

        <label>Gambar Produk *</label>
        <div id="product_image">
            
        @foreach($product_images as $product_image2)
            @if($product_image2->product_id == $product->product_id)
            <div class="fileUpload">
                <input id="uploadBtn{{$loop->iteration}}" type="file" name="product_image[]" class="upload" accept="image/*"/>
                <input class="form-control" id="uploadFile{{$loop->iteration}}" placeholder="{{$product_image2->product_image_name}}" disabled="disabled"/>
            </div>
            @endif
        @endforeach
            <!-- <div class="fileUpload">
                <input id="uploadBtn2" type="file" name="product_image[]" class="upload" accept="image/*" required/>
                <input class="form-control" id="uploadFile2" placeholder="Pilih Foto..." disabled="disabled"/>
            </div>
            <div class="fileUpload">
                <input id="uploadBtn3" type="file" name="product_image[]" class="upload" accept="image/*" required/>
                <input class="form-control" id="uploadFile3" placeholder="Pilih Foto..." disabled="disabled"/>
            </div> -->
        </div>
        <small class="form-text" style="margin-top:-15px">Pilih Minimal 3 Gambar. Pastikan gambar yang anda masukkan dapat dilihat dengan jelas.</small>
        
        <script>
            document.getElementById("uploadBtn1").onchange = function () {
                document.getElementById("uploadFile1").value = this.value;
                document.getElementById('uploadBtn2').setAttribute('required','required')
                document.getElementById('uploadBtn3').setAttribute('required','required')
            };

            document.getElementById("uploadBtn2").onchange = function () {
                document.getElementById("uploadFile2").value = this.value;
                document.getElementById('uploadBtn1').setAttribute('required','required')
                document.getElementById('uploadBtn3').setAttribute('required','required')
            };      

            document.getElementById("uploadBtn3").onchange = function () {
                document.getElementById("uploadFile3").value = this.value;
                document.getElementById('uploadBtn1').setAttribute('required','required')
                document.getElementById('uploadBtn2').setAttribute('required','required')

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
        </script>
        
        <div class="row">
            <div class="col-sm-6">
                <label>Berat *</label>
                <input type="number" name="heavy" class="form-control" min="1" value="{{$product->heavy}}" required>
                <small class="form-text">Berat dihitung dalam gram (gr).</small>
            </div><!-- End .col-sm-6 -->

            <div class="col-sm-6">
                <label>Stok *</label>
                <input type="number" id="qty" name="stok" class="form-control" min="0" step="1" data-decimals="0" value="{{$stock->stok}}" required>
            </div><!-- End .col-sm-6 -->
        </div><!-- End .row -->
        <div class="row">
            <div class="col-sm-5">
                <button type="submit" class="btn btn-primary btn-round">
                    <span>EDIT</span>
                </button>
            </div><!-- End .col-sm-6 -->
            
            <div class="col-sm-2" align="center">
                    <span>atau</span>
            </div><!-- End .col-sm-6 -->

            <div class="col-sm-5" align="center">
                <a href="../HapusProdukSupplier/{{$product_id}}" class="btn btn-primary btn-round" style="background-color: red">
                    <span>HAPUS</span>
                </a>
            </div><!-- End .col-sm-6 -->
        </div><!-- End .row -->
    </form>
    
    <script>
            function hanyaAngka(event) {
                var angka = (event.which) ? event.which : event.keyCode
                if ((angka < 48 || angka > 57) )
                    return false;
                return true;
            }
        </script>
</div><!-- .End .tab-pane -->

@endsection

