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
                        <h1>GALLERY</h1>

                        <div class="row mt-2">
                            <div class="col-md-3 p-3 border">
                                <p class="title-card-warehouse">Kategori Barang</p>
                                <p class="fw-bold">100</p>
                            </div>
                            <div class="col-md-3 p-3 border ml-5">
                                <p class="title-card-warehouse">Total Barang</p>
                                <p class="fw-bold">100</p>
                            </div>
                            <div class="col-md-3 p-3 border ml-5">
                                <p class="title-card-warehouse">Jumlah Toko</p>
                                <p class="fw-bold">100</p>
                            </div>
                        </div>
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
                                            <th style="width: 100px">Nama</th>
                                            <th style="width: 100px">Harga</th>
                                            <th style="width: 100px">Jumlah</th>
                                            <th style="width: 100px">Kategori Barang</th>
                                            <th style="width: 100px">Berat Barang</th>
                                            <th style="width: 100px">Expired Date</th>
                                            <th style="width: 100px">Aksi</th>
                                            {{-- <th style="width: 100px" colspan="2">Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gallery as $item)
                                            <tr>
                                                <td>{{ (request()->input('page', 1) - 1) * 10 + $loop->iteration }}</td>
                                                <td>
                                                    <a href="">
                                                        {{ $item->product_name }}
                                                    </a>
                                                </td>
                                                <td>{{ $item->price }}</td>
                                                <td>{{ $item->stok }}</td>
                                                <td>{{ $item->category->nama_kategori }}</td>
                                                <td>{{ $item->heavy }}</td>
                                                <td>{{ $item->expired_at }}</td>

                                                <td class="text-center">
                                                    <!-- Example single danger button -->
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-secondary dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                        </button>
                                                        <div class="dropdown-menu ">
                                                            <a class="dropdown-item" href="#">Lihat</a>
                                                            <a class="dropdown-item" href="#">Edit</a>
                                                            <a class="dropdown-item" href="#">Hapus</a>
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- <td align="center" width="150px">
                                                    <button type="button" class="btn btn-block btn-info"
                                                        data-toggle="modal"
                                                        data-target="#modal-edit-{{ $item->id }}">Edit</button>
                                                </td>
                                                <td align="center" width="100px">
                                                    <a href="./hapus_bank/{{ $item->id }}"
                                                        class="btn btn-block btn-danger">Hapus</a>
                                                </td> --}}
                                            </tr>

                                            <div class="modal fade" id="modal-edit-{{ $item->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Bank</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card card-primary">
                                                                <!-- form start -->
                                                                <form action="./PostEditBank/{{ $item->id }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <label for="nama_bank">Nama Bank</label>
                                                                            <input type="text" class="form-control"
                                                                                name="nama_bank" id="nama_bank"
                                                                                placeholder="Masukkan nama bank."
                                                                                value="{{ $item->nama_bank }}" required>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.card-body -->

                                                                    <div class="card-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Submit</button>
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
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $gallery ->links() }}
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
