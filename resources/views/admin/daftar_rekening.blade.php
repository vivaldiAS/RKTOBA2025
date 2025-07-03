@extends('admin/layout/main')

@section('title', 'Admin - Rekening')

@section('container')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tabel Daftar Rekening</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tabel Daftar Rekening</li>
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
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead align="center">
                    <tr>
                        <th>Nama Toko</th>
                        <th>Atas Nama</th>
                        <th>Nama Bank</th>
                        <th>Nomor Rekening</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($rekenings as $rekening)
                    @foreach($merchants as $merchant)
                      @if($merchant->user_id == $rekening->user_id)
                    <tr>
                        <td>{{$merchant->nama_merchant}}</td>
                        <td>{{$rekening->atas_nama}}</td>
                        <td>{{$rekening->nama_bank}}</td>
                        <td>{{$rekening->nomor_rekening}}</td>
                    </tr>
                    @endif

                    
                    @endforeach
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