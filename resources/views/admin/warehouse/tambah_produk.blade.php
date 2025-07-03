@extends('admin/layout/mainwarehouse')

@section('title', 'Admin - Warehouse')

@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/warehouse.css') }}">
@endsection

@section('container')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tambah Produk</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.warehouse.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Tambah Produk</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form action="{{route('admin.addStock.warehouse')}}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="namaToko" class="col-md-4 col-form-label text-md-right">Nama Toko</label>
                                <div class="col-md-8">
                                    <select class="form-control border" id="namaToko" name="namaToko" required>
                                        <option value="" disabled selected>Pilih Toko</option>
                                        @foreach ($merchants as $merchant)
                                            <option value="{{ $merchant->merchant_id }}" >{{ $merchant->nama_merchant }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="kategoriProduk" class="col-md-4 col-form-label text-md-right">Kategori Produk</label>
                                <div class="col-md-8">
                                    <select class="form-control border" id="kategoriProduk" name="kategoriProduk" required>
                                        <option value="" disabled selected>Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category_id }}">{{ $category->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="namaProduk" class="col-md-4 col-form-label text-md-right">Nama Produk</label>
                                <div class="col-md-8">
                                    <select class="form-control border" id="namaProduk" name="namaProduk" required>
                                        <option value="" disabled selected>Pilih Produk</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="spesifikasi" class="col-md-4 col-form-label text-md-right">Spesifikasi Produk</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="spesifikasi" name="spesifikasi" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lokasi" class="col-md-4 col-form-label text-md-right">Lokasi</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="lokasi" name="lokasi" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jumlah" class="col-md-4 col-form-label text-md-right">Jumlah</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="hargamodal" class="col-md-4 col-form-label text-md-right">Harga Modal</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" id="hargamodal" name="hargamodal" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="hargajual" class="col-md-4 col-form-label text-md-right">Harga Jual</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" id="hargajual" name="hargajual" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tanggalExpired" class="col-md-4 col-form-label text-md-right">Tanggal Expired</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control" id="tanggalExpired" name="tanggalExpired" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-block bg-gradient-primary btn-sm">Tambah Produk</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection