@extends('admin/layout/mainwarehouse')

@section('title', 'Admin - Warehouse')

@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/warehouse.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endsection

@section('container')
<div class="content-wrapper">
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Produk</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.warehouse.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Edit Produk</li>
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
                            <form action="{{route('admin.updateProduk.warehouse', $stock->stock_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="namaToko" class="col-md-4 col-form-label text-md-right">Nama Toko</label>
                                    <div class="col-md-8">
                                        <select class="form-control border" id="namaToko" name="namaToko" required>
                                            <option value="" disabled selected>Pilih Toko</option>
                                            @foreach ($merchants as $merchant)
                                                <option value="{{ $merchant->merchant_id }}" @if($merchant->merchant_id == $stock->merchant_id) selected @endif>{{ $merchant->nama_merchant }}</option>
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
                                                <option value="{{ $category->category_id}}" @if($category->category_id == $stock->product->category_id) selected @endif>{{ $category->nama_kategori }}</option>
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
                                                <option value="{{ $product->product_id }}" @if($product->product_id == $stock->product_id) selected @endif>{{ $product->product_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="spesifikasi" class="col-md-4 col-form-label text-md-right">Spesifikasi Produk</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="spesifikasi" name="spesifikasi" value="{{ $stock->spesifikasi }}" required />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="lokasi" class="col-md-4 col-form-label text-md-right">Lokasi</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $stock->lokasi }}" required />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="jumlah" class="col-md-4 col-form-label text-md-right">Jumlah</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $stock->sisa_stok }}" required />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="hargamodal" class="col-md-4 col-form-label text-md-right">Harga Modal</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" id="hargamodal" name="hargamodal" value="{{ $stock->hargamodal }}" required />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="hargajual" class="col-md-4 col-form-label text-md-right">Harga Jual</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" id="hargajual" name="hargajual" value="{{ $stock->hargajual }}" required />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tanggalExpired" class="col-md-4 col-form-label text-md-right">Tanggal Expired</label>
                                    <div class="col-md-8">
                                        <input type="date" class="form-control" id="tanggalExpired" name="tanggalExpired" value="{{ $stock->tanggal_expired }}" required />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-block bg-gradient-primary btn-sm">Update Produk</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>  
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            // Tangkap event submit form
            $('form').submit(function(event) {
                // Mencegah perilaku default form
                event.preventDefault();

                // Lakukan AJAX request
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(response) {
                        // Tampilkan SweetAlert untuk memberi tahu pengguna bahwa update produk berhasil
                        Swal.fire({
                            icon: 'success',
                            title: 'Produk berhasil diperbarui',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            // Redirect pengguna ke halaman lain setelah menutup SweetAlert
                            window.location.href = '/admin/warhouse/index';
                        });
                    },
                    error: function(response) {
                        // Tangkap kesalahan jika ada
                        console.log(response);
                    }
                });
            });
        });
    </script>
@endsection
