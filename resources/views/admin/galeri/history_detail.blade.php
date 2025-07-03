@extends('admin/layout/main')

@section('title', 'Admin - Bank')

@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/warehouse.css') }}">
@endsection

@section('container')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-9">
                        <h1>History Detail Gallery</h1>
                    </div>
                    <div class="col-sm-3">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Gallery</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="fw-bold" style="font-size: 25px">Total Harga : Rp. {{ number_format($transactions->total, 2) }}</p> 
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead align="center">
                                        <tr>
                                            <th style="width: 50px">No</th>
                                            <th style="width: 100px">Merchant</th>
                                            <th style="width: 100px">Nama Produk</th>
                                            <th style="width: 500px">Deskripsi Produk</th>
                                            <th style="width: 100px">Kategori</th>
                                            <th style="width: 100px">Harga Barang</th>
                                            <th style="width: 100px">Jumlah</th>
                                            <th style="width: 100px">Total Harga</th>
                                            <th style="width: 100px">Berat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions->gallery as $gallery)
                                            <tr>
                                                <td>{{ (request()->input('page', 1) - 1) * 10 + $loop->iteration }}</td>
                                                <td class="text-capitalize">{{ $gallery->merchant->nama_merchant }}</td>
                                                <td>{{ $gallery->product_name }}</td>
                                                <td>{{ $gallery->product_description }}</td>
                                                <td><span class="badge bg-primary">{{ $gallery->category->nama_kategori }}</span></td>
                                                <td>Rp. {{ number_format($gallery->price, 2) }}</td>
                                                <td>{{ $gallery->pivot->quantity }}</td>
                                                <td>Rp. {{ number_format($gallery->price * $gallery->pivot->quantity, 2) }}</td>
                                                <td>{{ $gallery->heavy }} Gram</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- {{ $gallery ->links() }} --}}
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <div class="modal fade" id="modal-tambah_bank">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Bank</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="./PostTambahBank" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama_bank">Nama Bank</label>
                                    <input type="text" class="form-control" name="nama_bank" id="nama_bank"
                                        placeholder="Masukkan nama bank." required>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
