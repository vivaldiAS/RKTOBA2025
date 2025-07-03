
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
                    <h1 class="m-0">Laporan Pemesanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.warehouse.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">Laporan Pemesanan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="container float-left">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Tanggal Awal : </label>
                            </div>
                            <div class="col-md-3">
                                <label>Tanggal Akhir : </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="datefilter" id="datefilter">
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="endDateFilter" id="endDateFilter">
                            </div>
                            <div class="col-md-2 align-self-end">
                                <button type="button" id="search_button" class="btn btn-info btn-sm btn-block">
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Purchase Order</th>
                                    <th>Nama Produk</th>
                                    <th>Nama Toko</th>
                                    <th>Jumlah</th>
                                    <th>Harga per Unit</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal Pemesanan</th>
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
                                    <td class="harga">{{ $purchase['price'] }}</td>
                                    <td class="harga">{{ $purchase['jumlah_pembelian_produk'] * $purchase['price']}}</td>
                                    <td class="tanggal">{{ $purchase['created_at']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function confirmDelete(event, url) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }

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

    $(document).ready(function() {
        $('.harga').each(function() {
            var angka = $(this).text();
            var hargaRupiah = formatRupiah(angka, 'Rp ');
            $(this).text(hargaRupiah);
        });

        $('#search_button').click(function() {
            var startDate = $('#datefilter').val();
            var endDate = $('#endDateFilter').val();

            $.ajax({
                url: '{{ route("admin.searchByDate.warehouse") }}',
                type: 'GET',
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    var tbody = $('#example1 tbody');
                    tbody.empty();

                    $.each(response.purchasesAPI, function(index, purchase) {
                        var row = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + purchase.kode_pembelian + '</td>' +
                            '<td>' + purchase.product_name + '</td>' +
                            '<td>' + purchase.nama_merchant + '</td>' +
                            '<td>' + purchase.jumlah_pembelian_produk + '</td>' +
                            '<td class="harga">' + formatRupiah(purchase.price, 'Rp ') + '</td>' +
                            '<td class="harga">' + formatRupiah(purchase.jumlah_pembelian_produk * purchase.price, 'Rp ') + '</td>' +
                            '<td class="tanggal" >' + purchase.created_at + '</td>' +
                            '</tr>';
                        tbody.append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        $('.tanggal').each(function() {
            var tanggal = $(this).text();
            var tanggalFormatted = formatTanggal(tanggal);
            $(this).text(tanggalFormatted);
        });
    });
</script>
@endsection