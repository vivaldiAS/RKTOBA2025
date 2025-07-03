@extends('admin/layout/mainwarehouse')

@section('title', 'Admin - Warehouse')

@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/warehouse.css') }}">
@endsection

@section('container')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pembelian Produk</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.warehouse.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Pembelian Produk</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Purchase Order</th>
                                    <th>Nama Produk</th>
                                    <th>Nama Toko</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $index => $purchase)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $purchase['kode_pembelian'] }}</td>
                                        <td>{{ $purchase['product_name'] }}</td>
                                        <td>{{ $purchase['nama_merchant'] }}</td>
                                        <td>{{ $purchase['jumlah_pembelian_produk'] }}</td>
                                        <td>
                                            @php
                                                $status_pembelian = $purchase['status_pembelian'];
                                                $proof_of_payment_image = isset($purchase['proof_of_payment_image']) ? $purchase['proof_of_payment_image'] : null;
                                                $status = "";

                                                if ($status_pembelian === "status1" || $status_pembelian === "status1_ambil") {
                                                    $status = $proof_of_payment_image ? "Bukti Pembayaran Telah Dikirim. SILAHKAN KONFIRMASI." : "Belum Dapat Dikonfirmasi. TUNGGU BUKTI PEMBAYARAN.";
                                                } elseif ($status_pembelian === "status2" || $status_pembelian === "status2_ambil") {
                                                    $status = "Pesanan Sedang Diproses. TUNGGU PESANAN DIPROSES.";
                                                } elseif ($status_pembelian === "status3_ambil") {
                                                    $status = "MENUNGGU PELANGGAN MENGAMBIL PESANAN.";
                                                } elseif ($status_pembelian === "status3") {
                                                    $status = "Pesanan Sedang Dalam Perjalanan. TUNGGU PESANAN DITERIMA.";
                                                } elseif ($status_pembelian === "status4_ambil_a") {
                                                    $status = "Pesanan telah diberikan. TUNGGU PELANGGAN MENGKONFIRMASI PESANAN YANG TELAH DIAMBIL.";
                                                } elseif ($status_pembelian === "status4" || $status_pembelian === "status4_ambil_b") {
                                                    $status = "Transaksi Sukses. SILAHKAN KIRIM BAYARAN.";
                                                } elseif ($status_pembelian === "status5" || $status_pembelian === "status5_ambil") {
                                                    $status = "PENJUALAN DAN PEMBELIAN BERHASIL.";
                                                }
                                            @endphp
                                            {{ $status }}
                                        </td>
                                        <td>
                                        <a href="#" data-toggle="modal" data-target="#detailModal-{{ $purchase['product_purchase_id'] }}" data-id="{{ $purchase['product_purchase_id'] }}">
                                            Detail
                                        </a>
                                        </td>
                                    </tr>

                                    <div id="detailModal-{{ $purchase['product_purchase_id'] }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detailpembelianbarang" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel">Detail Pembelian Barang</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="detailForm">
                                                        <div class="form-group">
                                                            <label for="purchaseOrder">Purchase Order</label>
                                                            <input type="text" class="form-control" id="purchaseOrder" value="{{$purchase['kode_pembelian']}}"  readonly /> 
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="namaCustomer">Nama Customer</label>
                                                            <input type="text" class="form-control" id="namaCustomer" value="{{$purchase['name']}}" readonly />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="pembelian">Pesanan Barang</label>
                                                            <input type="text" class="form-control" id="pembelian" value="{{$purchase['product_name']}}" readonly />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="jumlahPesanan">Jumlah Pesanan</label>
                                                            <input type="text" class="form-control" id="jumlahPesanan" value="{{$purchase['jumlah_pembelian_produk']}}" readonly />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="namaToko">Nama Toko</label>
                                                            <input type="text" class="form-control" id="namaToko" value="{{$purchase['nama_merchant']}}" readonly />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="alamat">Alamat</label>
                                                            <textarea class="form-control" id="alamat" rows="3" readonly>{{$purchase['user_street_address']}}, {{$purchase['subdistrict_name']}}, {{$purchase['city_name']}}, {{$purchase['province_name']}},</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            @php
                                                                $status_pembelian = $purchase['status_pembelian'];
                                                                $proof_of_payment_image = isset($purchase['proof_of_payment_image']) ? $purchase['proof_of_payment_image'] : null;
                                                                $status = "";
                                                                if ($status_pembelian === "status1" || $status_pembelian === "status1_ambil") {
                                                                    $status = $proof_of_payment_image ? "Bukti Pembayaran Telah Dikirim. SILAHKAN KONFIRMASI." : "Belum Dapat Dikonfirmasi. TUNGGU BUKTI PEMBAYARAN.";
                                                                } elseif ($status_pembelian === "status2" || $status_pembelian === "status2_ambil") {
                                                                    $status = "Pesanan Sedang Diproses. TUNGGU PESANAN DIPROSES.";
                                                                } elseif ($status_pembelian === "status3_ambil") {
                                                                    $status = "MENUNGGU PELANGGAN MENGAMBIL PESANAN.";
                                                                } elseif ($status_pembelian === "status3") {
                                                                    $status = "Pesanan Sedang Dalam Perjalanan. TUNGGU PESANAN DITERIMA.";
                                                                } elseif ($status_pembelian === "status4_ambil_a") {
                                                                    $status = "Pesanan telah diberikan. TUNGGU PELANGGAN MENGKONFIRMASI PESANAN YANG TELAH DIAMBIL.";
                                                                } elseif ($status_pembelian === "status4" || $status_pembelian === "status4_ambil_b") {
                                                                    $status = "Transaksi Sukses. SILAHKAN KIRIM BAYARAN.";
                                                                } elseif ($status_pembelian === "status5" || $status_pembelian === "status5_ambil") {
                                                                    $status = "PENJUALAN DAN PEMBELIAN BERHASIL.";
                                                                }
                                                            @endphp
                                                            <textarea class="form-control" id="status" rows="3" readonly>{{$status}}</textarea>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>
@endsection
