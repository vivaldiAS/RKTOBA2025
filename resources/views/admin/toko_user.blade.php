@extends('admin/layout/main')

@section('title', 'Admin - Toko User')

@section('container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tabel Toko User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">Tabel Toko User</li>
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
                        <th>ID Toko</th>
                        <th>Nama Toko</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action 1</th>
                        <th>Action 2</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($merchants as $merchants)
                    <tr>
                        <td>{{$merchants->merchant_id}}</td>
                        <td>{{$merchants->nama_merchant}}</td>
                        <td>{{$merchants->username}}</td>
                        <td>{{$merchants->email}}</td>
                        @if($merchants->is_verified==1)
                            <td align="center"><small class="badge badge-success">Verified</small></td>
                        @else
                            <td align="center"><small class="badge badge-danger">No Verified</small></td>
                        @endif
                        <td align="center">
                          <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#modal-cek-{{$merchants->merchant_id}}">Cek</button>
                        </td>
                        <td align="center">
                          @if($merchants->is_closed == 0)
                            <button data-merchantIDToModCl="{{ $merchants->merchant_id }}" class="btn-close-modal btn btn-danger">Tutup</button>
                          @endif
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="modal-cek-{{$merchants->merchant_id}}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <h4 class="modal-title">Cek User</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                  <center><a>{{$merchants->deskripsi_toko}}</a></center>
                                  <center><a>{{$merchants->kontak_toko}}</a></center>
                                  <center><a href="./asset/u_file/foto_merchant/{{$merchants->foto_merchant}}" target="_blank">Lihat Foto Toko</a></center>
                                  
                                  <?php
                                    $merchant_address = DB::table('merchant_address')->where('merchant_id', $merchants->merchant_id)->first();
                                  ?>
                                  
                                  @if($merchant_address)
                                    <br><center><a>{{$merchant_address->province_name}}</a></center>
                                    <center><a>{{$merchant_address->city_name}}</a></center>
                                    <center><a>{{$merchant_address->subdistrict_name}}</a></center>
                                    <center><a>{{$merchant_address->merchant_street_address}}</a></center>
                                  @endif
                              </div>
                              <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  @if($merchants->is_verified==1)

                                  @else
                                    @if($cek_admin_id->is_admin == 1)
                                      <a href="./verify_toko/{{$merchants->merchant_id}}" class="btn btn-primary">Verify</a>
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
                    
                    <div class="modal" id="toCloseModal">
                      <div class="modal-dialog">
                        <div class="modal-content">

                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Tutup Toko</h4>
                            <button type="button" class="close" data-dismiss="modal">&times</button>
                          </div>

                          <!-- Modal body -->
                          <div class="modal-body">
                              Apakah anda yakin ingin menutup toko ini?
                          </div>

                          <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              
                              <div id="tutupTokoButton">

                              </div>
                          </div>

                        </div>
                      </div>
                    </div>

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


@section("custom_script")
<script>
  $(".btn-close-modal").on( "click", function() {
    let datatomodalclose = $(this).data("merchantidtomodcl");

    $.ajax({url:`/close_merchant_modal/${datatomodalclose}`, success: function(result){
      $('#toCloseModal').modal('show');
      $('#tutupTokoButton').empty();
      $("#tutupTokoButton").append(`<button type="button" data-merchantIDToCl="${result.merchant.merchant_id}" onclick="hapusPembelian(this, ${result.merchant.merchant_id})" class="btn-close btn btn-primary">IYA</button>`)
    }});
  });

  function hapusPembelian(button, merchantIDToCl) {
    let datatoclose = $(button).data("merchantidtocl");
    window.location.href = `tutup_toko/${datatoclose}`;
  };
</script>
@endsection