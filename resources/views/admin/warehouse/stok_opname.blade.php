@extends('admin/layout/mainwarehouse')

@section('title', 'Admin - Warehouse')

@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/warehouse.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
@endsection

@section('container')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stok Opname Warehouse</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.warehouse.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">Stok Opname Warehouse</li>
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
                                <th>Nama Produk</th>
                                <th>Nama Toko</th>
                                <th>Tanggal Pengecekan</th>
                                <th>Nama Penanggung Jawab</th>
                                <th>Jumlah Yang Kurang</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($stock_opname as $index => $stok_opnames)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $stok_opnames->product_name }}</td>
                                    <td>{{ $stok_opnames->nama_merchant }}</td>
                                    <td class="tanggal">{{ $stok_opnames->tanggal_keluar }}</td>
                                    <td>{{ $stok_opnames->penanggung_jawab }}</td>
                                    <td>{{ $stok_opnames->jumlah_barang }}</td>
                                    <td>{{$stok_opnames->keterangan}}</td>
                                    <td>
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <a href="{{ route('admin.editStokOpname.warehouse', $stok_opnames['id']) }}" class="btn btn-success btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0)" class="btn btn-danger btn-sm rounded-0" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="confirmDelete(event, '{{ route('admin.deleteStokOpname.warehouse', $stok_opnames['id']) }}')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </li>
                                    
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <div class="col-md-12">
                        <div class="float-right">
                            <button type="button" class="btn btn-block bg-gradient-primary btn-sm" onclick="window.location.href = '/admin/Tambahstokopname';">
                                Tambah data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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

    $(document).ready(function() {
        $('.tanggal').each(function() {
            var tanggal = $(this).text();
            var tanggalFormatted = formatTanggal(tanggal);
            $(this).text(tanggalFormatted);
        });
    });
</script>
@endsection
