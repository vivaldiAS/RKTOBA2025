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
            <h1 class="m-0">Data Warehouse</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.warehouse.index')}}">Home</a></li>
              <li class="breadcrumb-item active">Data Warehouse</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Produk Baru</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="new-products-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Nama Tenant</th>
                            <th>Jumlah Masuk</th>
                            <th>Kategori Produk</th>
                            <th>Spesifikasi Produk</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Expired</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($newProducts as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->merchant_name }}</td>
                                <td>{{ $product->jumlah_stok }}</td>
                                <td>{{ $product->kategori_produk }}</td>
                                <td>{{ $product->spesifikasi }}</td>
                                <td>{{ $product->tanggal_masuk }}</td>
                                <td>{{ $product->tanggal_expired }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada produk baru</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Produk Akan Kedaluwarsa</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="expiring-products-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Nama Tenant</th>
                            <th>Jumlah Barang Tersedia</th>
                            <th>Kategori Produk</th>
                            <th>Spesifikasi Produk</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Expired</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expiringProducts as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->merchant_name }}</td>
                                <td>{{ $product->sisa_stok }}</td>
                                <td>{{ $product->kategori_produk }}</td>
                                <td>{{ $product->spesifikasi }}</td>
                                <td>{{ $product->tanggal_masuk }}</td>
                                <td>{{ $product->tanggal_expired }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada produk yang akan kedaluwarsa</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
