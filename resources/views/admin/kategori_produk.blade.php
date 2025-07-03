@extends('admin/layout/main')

@section('title', 'Admin - Kategori Produk')

@section('container')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tabel Kategori Produk</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tabel Kategori Produk</li>
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
              <div class="card-header">
                @if($cek_admin_id->is_admin == 1)
                  <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#modal-tambah_bank">Tambah Kategori Produk</button>
                @elseif($cek_admin_id->is_admin == 2)
                  <button type="button" class="btn btn-block btn-info" disabled>Tambah Kategori Produk</button>
                @endif
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead align="center">
                    <tr>
                        <th>Nama Kategori Produk</th>
                        <th colspan="1">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($categories as $categories)
                    <tr>
                        <td>{{$categories->nama_kategori}}</td>
                        <td align="center" width="150px">
                          @if($cek_admin_id->is_admin == 1)
                            <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#modal-edit-{{$categories->category_id}}">Edit</button>
                          @elseif($cek_admin_id->is_admin == 2)
                            <button type="button" class="btn btn-block btn-info" disabled>Edit</button>
                          @endif
                        </td>
                        <!-- <td align="center" width="100px">
                            <a href="./hapus_kategori_produk/{{$categories->category_id}}" class="btn btn-block btn-danger">Hapus</a>
                        </td> -->
                    </tr>

                    <div class="modal fade" id="modal-edit-{{$categories->category_id}}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Kategori</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card card-primary">
                                    <!-- form start -->
                                    <form action="./PostEditKategoriProduk/{{$categories->category_id}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="nama_kategori">Nama Kategori</label>
                                                <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" placeholder="Masukkan nama kategori." value="{{$categories->nama_kategori}}" required>
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
                    @endforeach
                  </tbody>
                </table>
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
                <h4 class="modal-title">Tambah Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                <!-- form start -->
                <form action="./PostTambahKategoriProduk" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" placeholder="Masukkan nama kategori." required>
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