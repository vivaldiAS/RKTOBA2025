@extends('admin/layout/main')

@section('title', 'Admin - Kategori Tipe Spesifikasi Produk Grosir')

<style>
  .checkbox_specification_types {
    border: 1px solid rgba(0,0,0,.2);
    height: 200px;
    overflow: scroll;
  }
  
  .checkbox_specification_types div{
    padding: 2px;
  }
</style>

@section('container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tabel Kategori Tipe Spesifikasi Produk Grosir</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tabel Kategori Tipe Spesifikasi Produk Grosir</li>
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
                <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#modal-tambah_bank">Tambah Spesifikasi Produk Grosir</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead align="center">
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Nama Tipe Spesifikasi</th>
                        <th colspan="1">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                    @foreach($category_type_specifications as $category_type_specifications)
                    <tr>
                        <td>{{$category_type_specifications->nama_kategori}}</td>
                        <td>{{$category_type_specifications->nama_jenis_spesifikasi}}</td>
                        <td align="center" width="150px">
                            <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#modal-edit-{{$category_type_specifications->category_type_specification_id}}">Edit</button>
                        </td>
                        <!-- <td align="center" width="100px">
                            <a href="./hapus_kategori_tipe_spesifikasi/{{$category_type_specifications->category_type_specification_id}}" class="btn btn-block btn-danger">Hapus</a>
                        </td> -->
                    </tr>

                    <div class="modal fade" id="modal-edit-{{$category_type_specifications->category_type_specification_id}}">
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
                                    <form action="./PostEditKategoriTipeSpesifikasiProdukSupplier/{{$category_type_specifications->category_type_specification_id}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        <div class="card-body">
                                        <div class="form-group">
                                            <label for="nama_spesifikasi">Jenis Spesifikasi</label>
                                            <div class="checkbox_specification_types col-md-12">
                                              @foreach($specification_types as $specification_types2)
                                              <div>
                                                <input class="" type="radio" name="specification_type_id[]" id="divisi[{{$specification_types2->specification_type_id}}]" value="{{$specification_types2->specification_type_id}}">
                                                <label class="form-check-label" for="divisi[{{$specification_types2->specification_type_id}}]">{{$specification_types2->nama_jenis_spesifikasi}}</label>
                                              </div>
                                              @endforeach
                                            </div>
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
                <h4 class="modal-title">Tambah Jenis Spesifikasi Produk Grosir</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                <!-- form start -->
                <form action="./PostTambahKategoriTipeSpesifikasiProdukSupplier" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_kategori_produk">Nama Kategori Produk Grosir</label>
                            <select class="form-control select2bs4" id="nama_kategori_produk" name="category_id" required>
                                <option selected disabled value="">Pilih Kategori Produk Grosir</option>
                                @foreach($categories as $categories)
                                  <option value="{{$categories->category_id}}">{{$categories->nama_kategori}}</option>
                                @endforeach
                            </select>
                        </div>
                            
                        <div class="form-group">
                            <label for="nama_spesifikasi">Jenis Spesifikasi Produk Grosir</label>
                            <div class="checkbox_specification_types col-md-12">
                              @foreach($specification_types as $specification_types)
                              <div>
                                <input class="" type="checkbox" name="specification_type_id[]" id="divisi[{{$specification_types->specification_type_id}}]" value="{{$specification_types->specification_type_id}}">
                                <label class="form-check-label" for="divisi[{{$specification_types->specification_type_id}}]">{{$specification_types->nama_jenis_spesifikasi}}</label>
                              </div>
                              @endforeach
                            </div>
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