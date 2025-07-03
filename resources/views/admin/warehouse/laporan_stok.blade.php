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
                    <h1 class="m-0">Laporan Stok</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.warehouse.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">Laporan Stok</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Toko</th>
                                <th>Category</th>
                                <th>Nama Produk</th>
                                <th>Stok Masuk</th>
                                <th>Stok Keluar</th>
                                <th>Sisa Stok</th>
                                <th>Harga Modal</th>
                                <th>Harga Jual</th>
                                <th>Total Keuntungan</th>
                                <th>Tanggal Masuk</th>
                                <th>Transaksi Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $index => $datas)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$datas['merchant_name']}}</td>
                            <td>{{$datas['kategori']}}</td>
                            <td>{{$datas['product_name']}}</td>
                            <td>{{$datas['stok']}}</td>
                            <td>{{$datas['total_barang_keluar']}}</td>
                            <td>{{$datas['stok_tersisa']}}</td>
                            <td class="harga">{{$datas['hargamodal']}}</td>
                            <td class="harga">{{$datas['hargajual']}}</td>
                            <td class="harga keuntungan">
                                @php
                                $barang = $datas['hargajual'] - $datas['hargamodal'];
                                $total_price = $barang * $datas['total_barang_keluar'];
                                @endphp
                                {{$total_price}}
                            </td>
                            <td class="tanggal">{{$datas['tanggal_masuk']}}</td>
                            <td class="tanggal">{{$datas['transaksi_terakhir']}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="12"> Total Keuntungan Keseluruhan : <span class="total-keuntungan"></span> </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function formatRupiah(angka, prefix) {
        var number_string = angka.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix === undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }

    function formatTanggal(tanggal) {
        var options = { day: 'numeric', month: 'numeric', year: 'numeric' };
        var date = new Date(tanggal);
        return date.toLocaleDateString('id-ID', options);
    }

    function calculateTotalProfit() {
        var total = 0;
        $('.keuntungan').each(function() {
            var profit = $(this).text().replace(/[^,\d]/g, '');
            total += parseInt(profit);
        });
        return total;
    }

    $(document).ready(function() {
        $('.harga').each(function() {
            var angka = $(this).text();
            var hargaRupiah = formatRupiah(angka, 'Rp ');
            $(this).text(hargaRupiah);
        });

        $('.tanggal').each(function() {
            var tanggal = $(this).text();
            var tanggalFormatted = formatTanggal(tanggal);
            $(this).text(tanggalFormatted);
        });

        var totalProfit = calculateTotalProfit();
        var formattedTotalProfit = formatRupiah(totalProfit, 'Rp ');
        $('.total-keuntungan').text(formattedTotalProfit);
    });
</script>
@endsection
