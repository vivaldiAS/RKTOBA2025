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
                    <div class="col-sm-9 warehouse">
                        <h1>Request Gallery</h1>
                        <form action="" method="get">
                            <input type="text" class="input-search mt-2" placeholder="Cari Produk" name="query">
                            <button type="submit" class="d-none"></button>
                        </form>
                    </div>
                    <div class="col-sm-3">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Request Gallery</li>
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
                                            <th style="width: 100px">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <h2>Daftar Permintaan</h2>
                                        @foreach ($gallery as $item)
                                            <tr>
                                                <td>{{ (request()->input('page', 1) - 1) * 5 + $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ route('admin.request.gallery.show', $item->id) }}">
                                                        {{ $item->product_name }}
                                                    </a>
                                                </td>
                                                <td>{{ $item->price }}</td>
                                                <td>{{ $item->stok }}</td>
                                                <td>{{ $item->category->nama_kategori }}</td>
                                                <td>200 gr</td>
                                                <td>06-03-2023</td>
                                                <td>
                                                    @if ($item->is_accepted == 0)
                                                        <a class="badge badge-warning">Menunggu</a>
                                                    @elseif($item->is_accepted == 2)
                                                        <a class="badge badge-danger">Ditolak</a>
                                                    @endif

                                                </td>
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
                                {{ $gallery->links() }}
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
