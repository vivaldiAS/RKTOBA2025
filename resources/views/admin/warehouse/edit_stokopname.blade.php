@extends('admin/layout/mainwarehouse')

@section('title', 'Admin - Edit Warehouse')

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
                    <h1 class="m-0">Edit Stok Opname</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.warehouse.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Stok Opname</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif
            <div class="row justify-content-center">
                <div class="col-md-6">
                <form method="POST" action="{{ route('admin.updateStokOpname.warehouse', $stock_opname->id) }}">
                        @csrf
                        <div class="form-group row">
                            <label for="namaProduk" class="col-md-4 col-form-label text-md-right">Nama Produk</label>
                            <div class="col-md-8">
                                <select class="form-control border" id="stock_id" name="stock_id" required>
                                    <option value="" disabled>Pilih Produk</option>
                                    @foreach ($products as $stok)
                                                <option value="{{ $stok->stock_id }}" @if($stok->stock_id == $stock_opname->stock_id) selected @endif>
                                                    {{ $stok->product->product_name }} 
                                                </option>                                    
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="penanggung_jawab" class="col-md-4 col-form-label text-md-right">Nama Penanggung Jawab</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" required value="{{ $stock_opname->penanggung_jawab }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jumlah_barang" class="col-md-4 col-form-label text-md-right">Jumlah Barang Yang Kurang</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" required value="{{ $stock_opname->jumlah_barang }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_pengecekan" class="col-md-4 col-form-label text-md-right">Tanggal Pengecekan</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" id="tanggal_pengecekan" name="tanggal_keluar" value="{{ $stock_opname->tanggal_keluar }}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keterangan" class="col-md-4 col-form-label text-md-right">Keterangan</label>
                            <div class="col-md-8">
                                <input type="input" class="form-control" id="keterangan" name="keterangan" required value="{{ $stock_opname->keterangan }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-block bg-gradient-primary btn-sm" id="submitBtn">Tambah Stok Opname</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            $('form').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Produk berhasil diperbarui',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = "{{route('admin.warehouse.index')}}";
                        });
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });
        });
    </script>
@endsection
