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
            <h1>Tabel Sub Kategori Produk</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tabel Sub Kategori Produk</li>
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
                <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#modal-tambah_bank">Tambah Sub Kategori Produk</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead align="center">
                    <tr>
                        <th>Nama Sub Kategori Produk</th>
                        <th colspan="1">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($subCategory as $item)
                    <tr>
                        <td>{{$item->nama_sub_kategori}}</td>
                        <td align="center" width="150px">
                            <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#modal-edit-{{$item->id}}">Edit</button>
                        </td>
                        <!-- <td align="center" width="100px">
                            <a href="./hapus_kategori_produk/{{$item->id}}" class="btn btn-block btn-danger">Hapus</a>
                        </td> -->
                    </tr>

                    <div class="modal fade" id="modal-edit-{{$item->id}}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Sub Kategori</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card card-primary">
                                    <!-- form start -->
                                    <form action="./PostEditSubKategoriProduk/{{$item->id}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="nama_sub_kategori">Nama Sub Kategori</label>
                                                <input type="text" class="form-control" name="nama_sub_kategori" id="nama_sub_kategori" placeholder="Masukkan nama sub kategori." value="{{$item->nama_sub_kategori}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="category_id">Kategori</label>
                                                <select id="category_id" class="form-control" name="category_id">
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach ($category as $item)
                                                    <option value="{{ $item->category_id }}" {{ $item->category_id == $item->category_id ? 'selected' : '' }}>{{ $item->nama_kategori }}</option>
                                                    @endforeach
                                                </select>
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
                <h4 class="modal-title">Tambah Sub Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                <!-- form start -->
                <form action="./PostTambahSubKategoriProduk" method="post">
                @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_sub_kategori">Nama Sub Kategori</label>
                            <input type="text" class="form-control" name="nama_sub_kategori" id="nama_sub_kategori" placeholder="Masukkan nama sub kategori." required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select id="category_id" class="form-control" name="category_id">
                                <option value="">Pilih Kategori</option>
                                @foreach ($category as $item)
                                <option value="{{ $item->category_id }}">{{ $item->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
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
