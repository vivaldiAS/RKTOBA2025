@extends('admin/layout/main')

@section('title', 'Admin - Bank')

@section('container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
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
                  <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#modal-tambah_bank">Tambah Bank</button>
                @elseif($cek_admin_id->is_admin == 2)
                  <button type="button" class="btn btn-block btn-info" disabled>Tambah Bank</button>
                @endif
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead align="center">
                    <tr>
                        <th>Nama Bank</th>
                        <th colspan="2">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($banks as $banks)
                    <tr>
                        <td>{{$banks->nama_bank}}</td>
                        @if($cek_admin_id->is_admin == 1)
                          <td align="center" width="150px">
                              <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#modal-edit-{{$banks->id}}">Edit</button>
                          </td>
                          <td align="center" width="100px">
                              <a href="./hapus_bank/{{$banks->id}}" class="btn btn-block btn-danger">Hapus</a>
                          </td>
                        @elseif($cek_admin_id->is_admin == 2)
                          <td align="center" width="150px">
                              <button type="button" class="btn btn-block btn-info" disabled>Edit</button>
                          </td>
                          <td align="center" width="100px">
                              
                          </td>
                        @endif
                    </tr>

                    <div class="modal fade" id="modal-edit-{{$banks->id}}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Bank</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card card-primary">
                                    <!-- form start -->
                                    <form action="./PostEditBank/{{$banks->id}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="nama_bank">Nama Bank</label>
                                                <input type="text" class="form-control" name="nama_bank" id="nama_bank" placeholder="Masukkan nama bank." value="{{$banks->nama_bank}}" required>
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
                            <input type="text" class="form-control" name="nama_bank" id="nama_bank" placeholder="Masukkan nama bank." required>
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