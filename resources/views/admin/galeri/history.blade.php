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
                        <h1>History GALLERY</h1>
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
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead align="center">
                                        <tr>
                                            <th style="width: 50px">No</th>
                                            <th style="width: 100px">Jumlah Barang</th>
                                            <th style="width: 100px">Kategori</th>
                                            <th style="width: 100px">Total Harga</th>
                                            <th style="width: 100px">Tanggal</th>
                                            <th style="width: 100px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $item)
                                            <tr>
                                                <td>{{ (request()->input('page', 1) - 1) * 10 + $loop->iteration }}</td>
                                                <td>
                                                    {{ count($item->gallery) }}
                                                </td>
                                                @php
                                                    $category = [];
                                                    foreach ($item->gallery as $gallery) {
                                                        if (!in_array($gallery->category->nama_kategori, $category)) {
                                                            array_push($category, $gallery->category->nama_kategori);
                                                        }
                                                    }
                                                @endphp
                                                <td>
                                                    @foreach ($category as $c)
                                                        <span class="badge bg-primary">{{ $c }}</span>
                                                    @endforeach
                                                </td>
                                                <td>Rp. {{ number_format($item->total, 2) }}</td>
                                                <td>{{ $item->created_at }}</td>

                                                <td class="text-center">
                                                    <!-- Example single danger button -->
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-secondary dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                        </button>
                                                        <div class="dropdown-menu ">
                                                            <a class="dropdown-item" href="{{ route('admin.gallery.history.detail', ['id' => $item->id]) }}">Lihat</a>
                                                            <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Hapus</a>
                                                        </div>
                                                    </div>
                                                </td>
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
