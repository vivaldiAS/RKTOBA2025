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
    <form action="../PostEditJasaKreatif/{{$service_id}}" id="formProduct" method="post" enctype="multipart/form-data">
    @csrf
    <label>Pilih Sub Kategori *</label>
        <select class="form-control" name="sub_category_id" id="sub_category_id" disabled>
            @foreach($sub_categories as $sub_category)
            <option value="{{ $sub_category->id }}" {{ $sub_category->id == $service->sub_category_id ? 'selected' : '' }}>
                {{ $sub_category->nama_sub_kategori }}
            </option>            
            @endforeach
        </select>

        <label>Nama Jasa Kreatif *</label>
        <input type="text" name="service_name" class="form-control" value="{{$service->service_name}}" required>
        
        <label>Deskripsi Jasa Kreatif*</label>
        <textarea name="service_description" class="form-control" required>{{$service->service_description}}</textarea>
        
        <label>Harga *</label>
        <input type="number" name="price" class="form-control" onkeypress="return hanyaAngka(event)" value="{{$service->price}}" required>
        
        <label>Gambar Produk Lama</label>
        <div class="row">
        @foreach($service_images as $service_image1)
            @if($service_image1->service_id == $service->service_id)
            <div class="col-4 col-md-4 col-lg-4 col-xl-2">
                    <img src="../asset/u_file/service_image/{{$service_image1->service_image_name}}" alt="Service image" class="product-image">
                </div>
            @endif
        @endforeach
        </div>
            

        <label>Gambar Produk *</label>
        <div id="product_image">
            
        @foreach($service_images as $service_image2)
            @if($service_image2->service_id == $service->service_id)
            <div class="fileUpload">
                <input id="uploadBtn{{$loop->iteration}}" type="file" name="service_image[]" class="upload" accept="image/*"/>
                <input class="form-control" id="uploadFile{{$loop->iteration}}" placeholder="{{$service_image2->service_image_name}}" disabled="disabled"/>
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
                stre3 = "<div class='fileUpload'><input id='uploadBtn4' type='file' name='service_image[]' class='upload' accept='image/*'/><input class='form-control' id='uploadFile4' placeholder='Pilih Foto...' disabled='disabled'/></div>";
                $("#service_image").append(stre3);
                
                document.getElementById("uploadBtn4").onchange = function () {
                    document.getElementById("uploadFile4").value = this.value;

                    let stre4;
                    stre4 = "<div class='fileUpload'><input id='uploadBtn5' type='file' name='service_image[]' class='upload' accept='image/*'/><input class='form-control' id='uploadFile5' placeholder='Pilih Foto...' disabled='disabled'/></div>";
                    $("#service_image").append(stre4);
                    
                    document.getElementById("uploadBtn5").onchange = function () {
                        document.getElementById("uploadFile5").value = this.value;

                        let stre5;
                        stre5 = "<div class='fileUpload'><input id='uploadBtn6' type='file' name='service_image[]' class='upload' accept='image/*'/><input class='form-control' id='uploadFile6' placeholder='Pilih Foto...' disabled='disabled'/></div>";
                        $("#service_image").append(stre5);
                        
                        document.getElementById("uploadBtn6").onchange = function () {
                            document.getElementById("uploadFile6").value = this.value;        
                        };
                    };
                };
            };
        </script>

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
                <a href="../HapusJasaKreatif/{{$service_id}}" class="btn btn-primary btn-round" style="background-color: red">
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

