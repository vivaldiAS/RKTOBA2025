@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Warehouse')

@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/warehouse.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Warehouse</li>
@endsection

@section('container')
    <div class="col-12 warehouse">
        <div class="d-flex justify-content-between align-items-center">
            <p class="title-warehouse text-uppercase">Request Warehouse</p>
        </div>
        @if (session('status'))
            <div class="alert alert-{{ session('type') }} alert-dismissible fade show" role="alert">
                <h4 class="alert-heading text-capitalize">{{ session('type') }}</h4>
                <p class="fs-7">{{ session('status') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="col-12">
            <form action="{{ route('warehouse.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-7 p-0">
                        <p>Nama Toko : <span>{{ auth()->user()->merchant->nama_merchant }}</span></p>
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Jenis Produk*</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="jenis_produk">
                                @foreach ($categories as $item)
                                    <option value="{{ $item->category_id }}">{{ $item->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('jenis_produk')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    Please provide a valid city.
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Produk*</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="nama_produk">
                            @error('nama_produk')
                                <div id="validationServer03Feedback" class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Expired Date</label>
                            <input type="date" class="form-control" id="exampleInputEmail1" name="expired_date">
                            @error('expired_date')
                                <div id="validationServer03Feedback" class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Deskripsi Produk</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="deskripsi_produk"></textarea>
                            @error('deskripsi_produk')
                                <div id="validationServer03Feedback" class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Harga</label>
                            <div class="input-group mb-3 d-flex align-items-center">
                                <div class="input-group-prepend">
                                    Rp
                                </div>
                                <input type="number" class="form-control m-0 ml-3" name="harga">
                            </div>
                            @error('harga')
                                <div id="validationServer03Feedback" class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                            
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Berat</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" name="berat">
                                </div>
                                @error('berat')
                                    <div id="validationServer03Feedback" class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Jumlah</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" name="jumlah">
                                </div>
                                @error('jumlah')
                                    <div id="validationServer03Feedback" class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <p class="fw-bold">Gambar Produk</p>
                        <div class="upload-image-warehouse-box border">
                            <input type="file" name="upload_image" id="upload-image-warehouse">
                            <img class="add-image-warehouse-produk" id="add-image-warehouse-produk"
                                src="{{ asset('asset/image/image_upload.png') }}" alt="" srcset="">
                        </div>
                    </div>
                    <div class="col-12 p-0">
                        <button class="btn btn-success m-0">Request</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('asset/js/warehouse.js') }}"></script>
@endsection
