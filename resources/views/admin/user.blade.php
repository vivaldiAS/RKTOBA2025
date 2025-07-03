@extends('admin/layout/main')

@section('title', 'Admin - User')

@section('container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tabel Verifikasi User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">Tabel Verifikasi User</li>
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
              <!-- <div class="card-header">
                <h3 class="card-title"></h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead align="center">
                    <tr>
                        <th align="center">ID User</th>
                        <th align="center">Username</th>
                        <th align="center">Email</th>
                        <th align="center">Nama</th>
                        <th align="center">No Handphone</th>
                        <th align="center">Tanggal Lahir</th>
                        <th align="center">Jenis Kelamin</th>
                        <th align="center">Status</th>
                        <th align="center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($profile_users as $profile_user)
                      <tr>
                          <td>{{$profile_user->user_id}}</td>
                          <td>{{$profile_user->username}}</td>
                          <td>{{$profile_user->email}}</td>
                          <td>{{$profile_user->name}}</td>
                          <td>{{$profile_user->no_hp}}</td>
                          <td>{{$profile_user->birthday}}</td>
                          <?php
                              if($profile_user->gender == "L"){
                                $jenis_kelamin = "Laki-Laki";
                              }
                              else if($profile_user->gender == "P"){
                                $jenis_kelamin = "Perempuan";
                              }
                          ?>
                          <td>{{$jenis_kelamin}}</td>
                          
                          <?php $verify_user = DB::table('verify_users')->where('user_id', $profile_user->user_id)->first(); ?>
                          @if($verify_user)
                              @if($verify_user->is_verified==1)
                                  <td align="center"><small class="badge badge-success">Verified</small></td>
                              @else
                                  <td align="center"><small class="badge badge-danger">No Verified</small></td>
                              @endif
                          @else
                            <td align="center"><small class="badge badge-warning">None</small></td>
                          @endif
                          <td align="center">
                            <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#modal-cek-{{$profile_user->user_id}}">Cek</button>
                          </td>
                      </tr>
                      
                      <div class="modal fade" id="modal-cek-{{$profile_user->user_id}}">
                          <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Cek User</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if($verify_user)
                                      <center><a href="./asset/u_file/foto_ktp/{{$verify_user->foto_ktp}}" target="_blank">Lihat Foto KTP</a></center>
                                      <center><a href="./asset/u_file/foto_ktp_selfie/{{$verify_user->ktp_dan_selfie}}" target="_blank">Lihat Foto Selfie bersama KTP</a></center>
                                    @endif
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      @if($verify_user)
                                        @if($verify_user->is_verified==1)

                                        @else
                                          @if($cek_admin_id->is_admin == 1)
                                            <a href="./user/{{$verify_user->verify_id}}" class="btn btn-primary">Verify</a>
                                          @endif
                                        @endif
                                      @endif
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
@endsection