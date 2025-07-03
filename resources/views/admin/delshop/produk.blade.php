@extends('admin/layout/maindelshop')

@section('title', 'Admin - Delshop')

@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/warehouse.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endsection

@section('container')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Produk Warehouse</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Produk Warehouse</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Produk</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Stok</th>
                                    <th>Kategori Produk</th>
                                    <th>Spesifikasi Produk</th>
                                    <th>Harga Modal</th>
                                    <th>Harga Jual</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Expired</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($data))
                                    @foreach($data as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item['product_name'] }}</td>
                                            <td>{{ $item['sisa_stok'] }}</td>
                                            <td>{{ $item['kategori'] }}</td>
                                            <td>{{ $item['spesifikasi'] }}</td>
                                            <td class="harga">{{ $item['hargamodal'] }}</td>
                                            <td class="harga">{{ $item['hargajual'] }}</td>
                                            <td class="tanggal">{{ $item['tanggal_masuk'] }}</td>
                                            <td class="tanggal">{{ $item['tanggal_expired'] }}</td>
                                            <td> 
                                                <ul class="list-inline m-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('admin.editProduk.delshop', $item['stock_id']) }}" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="confirmDelete(event, '{{ route('admin.hapusproduk.delshop', $item['stock_id']) }}')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                @elseif(isset($error))
                                    <tr>
                                        <td colspan="8" class="text-center">{{ $error }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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

    function formatTanggal(tanggal) {
        var options = { day: 'numeric', month: 'numeric', year: 'numeric' };
        var date = new Date(tanggal);
        return date.toLocaleDateString('id-ID', options);
    }

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
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
    });
</script>
@endsection
