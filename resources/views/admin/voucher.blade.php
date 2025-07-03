@extends('admin/layout/main')

@section('title', 'Admin - Voucher')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
  .div_checkbox_categories {
    border: 1px solid rgba(0,0,0,.2);
    height: 200px;
    overflow: scroll;
  }
  
  .div_checkbox_categories div{
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
            <h1>Tabel Voucher</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tabel Voucher</li>
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
                  <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#modal-tambah_voucher">Tambah Voucher</button>
                @elseif($cek_admin_id->is_admin == 2)
                  <button type="button" class="btn btn-block btn-info" disabled>Tambah Voucher</button>
                @endif
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead align="center">
                        <th>Nama Voucher</th>
                        <th>Target Kategori</th>
                        <th>Potongan</th>
                        <th>Minimal Pengambilan</th>
                        <th>Maksimal Pemotongan</th>
                        <th>Tanggal Berlaku</th>
                        <th>Tanggal Batas Berlaku</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($vouchers as $vouchers)
                    <?php
                        $minimal_pengambilan = "Rp " . number_format($vouchers->minimal_pengambilan,0,',','.');
                        $maksimal_pemotongan = "Rp " . number_format($vouchers->maksimal_pemotongan,0,',','.');
                        $potongan_ongkir = "Rp " . number_format($vouchers->potongan,0,',','.');
                    ?>
                    <tr>
                        <td>{{$vouchers->nama_voucher}}</td>
                        
                        <?php
                            $target_kategori = explode(",", $vouchers->target_kategori);
                        ?>

                        <td>
                            @foreach($target_kategori as $target_kategori)
                                @foreach($categories as $categories1)
                                    @if($categories1->category_id == $target_kategori)
                                        {{$categories1->nama_kategori}},
                                    @endif
                                @endforeach
                            @endforeach
                        </td>

                        @if($vouchers->tipe_voucher == "pembelian")
                          <td>{{$vouchers->potongan}}%</td>
                        @elseif($vouchers->tipe_voucher == "ongkos_kirim")
                          <td>{{$potongan_ongkir}}</td>
                        @else
                          <td>{{$vouchers->potongan}}</td>
                        @endif
                        <td>{{$minimal_pengambilan}}</td>
                        <td>{{$maksimal_pemotongan}}</td>
                        <td>{{$vouchers->tanggal_berlaku}}</td>
                        <td>{{$vouchers->tanggal_batas_berlaku}}</td>
                        <td align="center" width="100px">
                          @if(date('Y-m-d') > $vouchers->tanggal_batas_berlaku)
                            <a>Batas Berlaku Habis</a>
                          @elseif(date('Y-m-d') <= $vouchers->tanggal_batas_berlaku)
                            @if($cek_admin_id->is_admin == 1)
                              <a href="./hapus_voucher/{{$vouchers->voucher_id}}" class="btn btn-block btn-danger">Hapus</a>
                            @endif
                          @endif
                        </td>
                    </tr>
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

<div class="modal fade" id="modal-tambah_voucher">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Voucher</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                <!-- form start -->
                <form action="./PostTambahVoucher" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_voucher">Nama Voucher</label>
                            <input type="text" class="form-control" name="nama_voucher" id="nama_voucher" placeholder="Masukkan nama voucher." required>
                        </div>
                        
                        <div class="form-group">
                            <label for="potongan">Tipe Voucher</label>
                            <select name="tipe_voucher" id="tipe_voucher" class="custom-select form-control" required>
                                <option value="" disabled selected>Pilih Tipe Voucher</option>
                                <option value="pembelian">Voucher Pembelian</option>
                                <option value="ongkos_kirim">Voucher Ongkos Kirim</option>
                            </select>
                            <!-- <input type="number" class="form-control" name="potongan" id="potongan" placeholder="Masukkan potongan yang diberikan voucher. (%)" required> -->
                        </div>

                        <div class="form-group" id="div_checkbox_categories">
                            <label for="nama_spesifikasi">Jenis Spesifikasi</label>
                            <div class="div_checkbox_categories col-md-12">
                              <div>
                                <input class="checkbox_categories" type="checkbox" id="SelectAll" value="all" onClick="select_all(this)">
                                <label class="form-check-label" for="SelectAll">Semua Kategori</label>
                              </div>
                              @foreach($categories as $categories2)
                              <div>
                                <input class="checkbox_categories" type="checkbox" name="target_kategori[]" id="divisi[{{$categories2->category_id}}]" value="{{$categories2->category_id}}">
                                <label class="form-check-label" for="divisi[{{$categories2->category_id}}]">{{$categories2->nama_kategori}}</label>
                              </div>
                              @endforeach
                            </div>
                        </div>

                        <div class="form-group" id="div_target_metode_pembelian">
                            <label for="target_metode_pembelian">Target Metode Pembelian</label>
                            <select name="target_metode_pembelian" id="target_metode_pembelian" class="custom-select form-control">
                                <option value="" selected>Semua</option>
                                <option value="ambil_ditempat">Ambil Ditempat</option>
                                <option value="pesanan_dikirim">Pesanan Dikirim</option>
                            </select>
                            <!-- <input type="number" class="form-control" name="potongan" id="potongan" placeholder="Masukkan potongan yang diberikan voucher. (%)" required> -->
                        </div>

                        <script>
                            function select_all(source) {
                                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                                for (var i = 0; i < checkboxes.length; i++) {
                                    if (checkboxes[i] != source)
                                        checkboxes[i].checked = source.checked;
                                }
                            }
                        </script>

                        <div class="form-group" id="potongan_div">
                            <label for="potongan">Potongan</label>
                            <!-- <input type="number" class="form-control" name="potongan" id="potongan" placeholder="Masukkan potongan yang diberikan voucher. (%)" required> -->
                        </div>
                        
                        <div class="form-group" id="minimal_pengambilan_div">
                            <label for="minimal_pengambilan">Minimal Pengambilan</label>
                            <input type="number" class="form-control" name="minimal_pengambilan" id="minimal_pengambilan" min="0" placeholder="Masukkan minimal belanja agar voucher dapat diambil. (Rp)" required>
                        </div>
                        
                        <div class="form-group" id="maksimal_pemotongan_div">
                            <label for="maksimal_pemotongan">Maksimal Pemotongan</label>
                            <!-- <input type="number" class="form-control" name="maksimal_pemotongan" id="maksimal_pemotongan" min="0" placeholder="Masukkan maksimal potongan belanjaan yang didapat." required> -->
                        </div>
                        
                        <div class="row" id="tanggal_voucher">
                            <div class="col-6">
                                <label for="tanggal_berlaku">Tanggal Berlaku</label>
                                <input type="date" class="form-control" name="tanggal_berlaku" min="<?php echo date('Y-m-d'); ?>" id="tanggal_berlaku" required>
                            </div>
                            
                            <div class="col-6">
                                <label for="tanggal_batas_berlaku">Tanggal Batas Berlaku</label>
                                <input type="date" class="form-control" name="tanggal_batas_berlaku" min="<?php echo date('Y-m-d'); ?>" id="tanggal_batas_berlaku" required>
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

<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#potongan_div").hide();
    $("#minimal_pengambilan_div").hide();
    $("#maksimal_pemotongan_div").hide();
    $("#tanggal_voucher").hide();
    $("#div_checkbox_categories").hide();
    $("#div_target_metode_pembelian").hide();
</script>
<script src="{{ URL::asset('asset/js/function_2.js') }}"></script>

@endsection