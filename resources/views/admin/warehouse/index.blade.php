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
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.warehouse.index')}}">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $availableProductsCount }}</h3>
                        <p>Barang Tersedia</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('admin.produk.warehouse')}}" class="small-box-footer">
                        Info Lebih lanjut <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>0</h3>
                        <p>Perlu Diambil</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{route('admin.pembelianproduk.warehouse')}}" class="small-box-footer">
                        Info Lebih lanjut <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>0</h3>
                        <p>Perlu Dikirim</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{route('admin.pembelianproduk.warehouse')}}" class="small-box-footer">
                        Info Lebih lanjut <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$soldProduct ?? ''}}</h3>
                        <p>Barang Keluar</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{route('admin.laporanstok.warehouse')}}" class="small-box-footer">
                        Info Lebih lanjut <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    <div class="card">
    <div class="card-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Nama Tenant</th>
                    <th>Jumlah Barang Tersedia</th>
                    <th>Kategori Produk</th>
                    <th>Spesifikasi Produk</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Expired</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data))
                    @foreach($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['product_name'] }}</td>
                            <td>{{ $item['merchant_name'] }}</td>
                            <td>{{ $item['sisa_stok'] }}</td>
                            <td>{{ $item['kategori'] }}</td>
                            <td>{{ $item['spesifikasi'] }}</td>
                            <td class="tanggal">{{ $item['tanggal_masuk'] }}</td>
                            <td class="tanggal">{{ $item['tanggal_expired'] }}</td>
                            
                        </tr>
                    @endforeach
                @elseif(isset($error))
                    <tr>
                        <td colspan="8" class="text-center">{{ $error }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <br>
        <div class="col-md-12">
            <div class="float-right">
                <button
                    type="button"
                    class="btn btn-block bg-gradient-primary btn-sm"
                    onclick="window.location.href = '/admin/TambahProdukWarehouse';"
                >
                    Tambah Produk
                </button>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function formatTanggal(tanggal) {
        var options = { day: 'numeric', month: 'numeric', year: 'numeric' };
        var date = new Date(tanggal);
        return date.toLocaleDateString('id-ID', options);
    }

    $(document).ready(function() {
        $('.tanggal').each(function() {
            var tanggal = $(this).text();
            var tanggalFormatted = formatTanggal(tanggal);
            $(this).text(tanggalFormatted);
        });
    });
</script>
@endsection