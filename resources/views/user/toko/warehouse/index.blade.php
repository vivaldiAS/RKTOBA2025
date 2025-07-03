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
            <p class="title-warehouse">Warehouse</p>
        </div>
        @if (session('status'))
            <div class="alert alert-success my-3">
                {{ session('status') }}
            </div>
        @endif
        <div class="col-md-12">
            <div class="row mt-2">
                <div class="col-md-3 p-4 border">
                    <p class="title-card-warehouse">Kategori Barang</p>
                    <p class="fw-bold">{{ $categories }}</p>
                </div>
                <div class="col-md-3 p-4 border ml-5">
                    <p class="title-card-warehouse">Total Barang Tersedia</p>
                    <p class="fw-bold">{{ $totalProducts }}</p>
                </div>
                <div class="col-md-3 p-4 border ml-5">
                    <p class="title-card-warehouse">Total Barang yang sudah terjual</p>
                    <p class="fw-bold">{{ $totalSoldProducts }}</p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12 p-4 border rounded-lg">
                <div class="card">
                <div class="card-body table-responsive">
                <p class="fw-bold">Daftar Produk Yang Tersedia</p>
                <br>
                <table id="example1" class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Kategori Barang</th>
                                <th>Expired Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produk as $index => $product)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $product->stocks->sum('sisa_stok') }}</td>
                                    <td>{{ $product->category->nama_kategori }}</td>
                                    <td>{{ $product->stocks->min('tanggal_expired') ? \Carbon\Carbon::parse($product->stocks->min('tanggal_expired'))->format('d-m-Y') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada produk pada warehouse</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
