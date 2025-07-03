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
                    <h1 class="m-0">Edit Transaksi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.warehouse.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Transaksi</li>
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
                            <form method="POST" action="{{ route('admin.updateTransaksi.warehouse', $transaksi->transaksi_id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <label for="stock_id" class="col-md-4 col-form-label text-md-right">Nama Produk</label>
                                    <div class="col-md-8">
                                        <select class="form-control border" id="stock_id" name="stock_id" required>
                                            <option value="" disabled selected>Pilih Produk</option>
                                            @foreach ($products as $stok)
                                                <option value="{{ $stok->stock_id }}" @if($stok->stock_id == $transaksi->stock_id) selected @endif>
                                                    {{ $stok->product->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="penanggung_jawab" class="col-md-4 col-form-label text-md-right">Nama Penanggung Jawab</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" value="{{ $transaksi->penanggung_jawab }}" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jumlah_barang_keluar" class="col-md-4 col-form-label text-md-right">Jumlah Barang Keluar</label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" id="jumlah_barang_keluar" name="jumlah_barang_keluar" value="{{ $transaksi->jumlah_barang_keluar }}" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggal_keluar" class="col-md-4 col-form-label text-md-right">Tanggal Keluar</label>
                                    <div class="col-md-8">
                                        <input type="date" class="form-control" id="tanggal_keluar" name="tanggal_keluar" value="{{ $transaksi->tanggal_keluar }}" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-block bg-gradient-primary btn-sm">Update Transaksi</button>
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
